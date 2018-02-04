<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function store(CommentRequest $request)
	{
	    $data = [
	        'user_id' => Auth::id(),
            'body' => $request->get('body'),
        ];
	    if (Route::currentRouteName() === 'comments.store') {
            $data['commentable_id'] = $request->get('id');
            $type = $request->get('type');
            if ($type === 'answer') {
                $data['commentable_type'] = Answer::class;
            } else if ($type === 'question') {
                $data['commentable_type'] = Question::class;
            } else {
                return response()->json([
                    'code' => -1,
                    'msg' => 'unknown comment type',
                ], 419);
            }
        } else {
	        $data['reply_to'] = $request->get('reply_to');
	        $reply_comment = Comment::find($data['reply_to']);
	        if (!$reply_comment) {
	            return response()->json([
	                'code' => -2,
                    'msg' => 'the comment reply to is not exist.'
                ]);
            }
            $data['commentable_id'] = $reply_comment->commentable_id;
	        $data['commentable_type'] = $reply_comment->commentable_type;
        }
        $comment = Comment::create($data);
		return response()->json([
		    'code' => 0,
            'comment' => [
                'id' => $comment->id,
                'body' => $comment->body,
                'time' => $comment->created_at->format('y-m-d \a\t h:i'),
                'user' => [
                    'id' => Auth::id(),
                    'name' => (Auth::user())->name,
                ],
            ],
        ]);
	}

	public function update(CommentRequest $request, Comment $comment)
	{
		$this->authorize('update', $comment);
		$comment->update($request->only(['id', 'body']));

		return response()->json([
		    'code' => 0,
        ]);
	}

	public function destroy(Comment $comment)
	{
		$this->authorize('destroy', $comment);
		$comment->delete();

		return response()->json([
		    'code' => 0,
        ]);
	}
}