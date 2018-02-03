<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function create(Question $question, Answer $answer)
	{
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
		return view('answers.create_and_edit', compact('answer'));
	}

	public function update(AnswerRequest $request, Answer $answer)
	{
		$this->authorize('update', $answer);
		$answer->update($request->all());

		return redirect()->route('answers.show', $answer->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Answer $answer)
	{
		$this->authorize('destroy', $answer);
		$answer->delete();

		return redirect()->route('answers.index')->with('message', 'Deleted successfully.');
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

}