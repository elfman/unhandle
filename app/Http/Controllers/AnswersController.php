<?php

namespace App\Http\Controllers;

use App\Events\AcceptAnswer;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function create(Answer $answer, Request $request)
	{
	    $question_id = $request->query('question_id');
	    $question = Question::find($question_id);
	    if (!$question) {
	        return 'missing query: question_id';
        }
		return view('answers.create_and_edit', compact('question', 'answer'));
	}

	public function store(AnswerRequest $request)
	{
	    $data = $request->only(['question_id', 'body']);
	    $data['user_id'] = Auth::id();
		$answer = Answer::create($data);
		return redirect()->route('questions.show', ['question' => $request->question_id, 'answer_id' => $answer->id])->with('message', 'Created successfully.');
	}

	public function edit(Answer $answer)
	{
        $this->authorize('update', $answer);
        $question = $answer->question;
		return view('answers.create_and_edit', compact('question', 'answer'));
	}

	public function update(AnswerRequest $request, Answer $answer)
	{
		$this->authorize('update', $answer);
		$answer->update($request->all());

		$url = route('questions.show', $answer->question->id) . '#answer' . $answer->id;
		return Redirect::to($url)->with('message', '修改成功');
	}

	public function destroy(Answer $answer)
	{
		$this->authorize('destroy', $answer);
		$answer->delete();

		return response()->json([
		    'code' => 0,
        ]);
	}

    public function vote(Answer $answer)
    {
        $this->authorize('vote', $answer);
        if (Route::currentRouteName() === 'answers.upvote') {
            $vote_change = $answer->upvote();
        } else {
            $vote_change = $answer->downvote();
        }

        return response()->json([
            'code' => 0,
            'vote_change' => $vote_change,
        ]);
	}

    public function accept(Answer $answer)
    {
        $this->authorize('accept', $answer);

        $question = $answer->question;
        if ($question->accept_answer !== null) {
            if ($question->accept_answer === $answer) {
                return response()->json([
                    'code' => 0,
                    'msg' => 'this answer is already accepted',
                ]);
            }
            Answer::where('id', $question->accept_answer)->update(['is_accepted' => false]);
        }
        $answer->is_accepted = true;
        $answer->question->accept_answer = $answer->id;

        $answer->save();
        $answer->question->save();

        event(new AcceptAnswer($answer, 'accept'));

        return response()->json([
            'code' => 0,
        ]);
	}

    public function cancelAccept(Answer $answer)
    {
        if (!$answer->is_accepted) {
            return response()->json([
                'code' => 1,
                'msg' => 'this answer is not accepted'
            ]);
        }

        $this->authorize('accept', $answer);

        $question = $answer->question;
        $question->accept_answer = null;
        $answer->is_accepted = false;
        $question->save();
        $answer->save();

        event(new AcceptAnswer($answer, 'cancel'));

        return response()->json([
            'code' => 0,
        ]);
	}
}