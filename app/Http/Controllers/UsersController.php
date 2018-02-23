<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function show(User $user)
    {
        $questions = Question::where('user_id', $user->id)->recent()->paginate(7);
        $answers = Answer::where('user_id', $user->id)->recent()->with('question')->paginate(7);
        return view('users.show',compact('user', 'questions', 'answers'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user, ImageUploadHandler $uploader)
    {
        $this->authorize('update', $user);
        $data = $request->only('name', 'email', 'introduction');

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 400);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);

        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功');
    }

    public function questions(User $user)
    {
        $questions = Question::where('user_id', $user->id)->recent()->paginate(10);
        return view('users.questions', compact('user', 'questions'));
    }

    public function answers(User $user)
    {
        $answers = Answer::where('user_id', $user->id)->recent()->with('question')->paginate(10);
        return view('users.answers', compact('user', 'answers'));
    }
}
