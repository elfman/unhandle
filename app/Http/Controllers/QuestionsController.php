<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Question $question)
	{
		$questions = $question->orderBy('created_at', 'desc')->paginate(20);
		return view('questions.index', compact('questions'));
	}

    public function show(Question $question)
    {
        $question->with(['answers', 'answers.user', 'user', 'comments', 'comments.user', 'answers.comments', 'answers.comments.user']);
        return view('questions.show', compact('question'));
    }

	public function create(Question $question)
	{
		return view('questions.create_and_edit', compact('question'));
	}

	public function store(QuestionRequest $request)
	{
	    $data = $request->only(['title', 'body']);
	    $data['user_id'] = Auth::id();


		$question = Question::create($data);

        $tags = $request->get('tags');
        $tags = explode(',', $tags);
        if (sizeof($tags) === 0) {
            array_push($tags, 'untag');
        }
		$question->attachTags($tags);

		return redirect()->route('questions.show', $question->id)->with('message', '成功创建问题');
	}

	public function edit(Question $question)
	{
        $this->authorize('update', $question);
		return view('questions.create_and_edit', compact('question'));
	}

	public function update(QuestionRequest $request, Question $question)
	{
		$this->authorize('update', $question);
		$question->update($request->all());

		return redirect()->route('questions.show', $question->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Question $question)
	{
		$this->authorize('destroy', $question);
		$question->delete();

		return response()->json([
		    'code' => 0,
        ]);
	}

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        $data = [
            'success' => false,
            'msg' => '上传失败！',
            'path' => ''
        ];

        if ($file = $request->file) {
            $result = $uploader->save($file, 'questions', Auth::id(), 1024);

            if ($result) {
                $data = [
                    'success' => true,
                    'msg' => '上传成功',
                    'filename' => $result['path'],
                ];
            }
        }
        return $data;
	}

    public function vote(Question $question)
    {
        $this->authorize('vote', $question);
        if (Route::currentRouteName() === 'questions.upvote') {
            $vote_change = $question->upvote();
        } else {
            $vote_change = $question->downvote();
        }

        return response()->json([
            'code' => 0,
            'vote_change' => $vote_change,
        ]);
	}

    public function my()
    {
        $questions = Question::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(20);
        return view('questions.index', compact('questions'));

	}
}