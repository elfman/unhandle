<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Overtrue\LaravelSocialite\Socialite;

class OauthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $github_user = Socialite::driver('github')->user();

        if (Auth::check()) { // 已登录，绑定账号
            if (Auth::user()->github_id == null) {
                $exist = User::where('github_id', $github_user->id)->first();
                if ($exist) {
                    return redirect()->route('users.edit', Auth::id())->with('error', '该github账号已绑定其它账号，不能重复绑定');
                }

                $user = Auth::user();
                $user->github_id = $github_user->id;
                $user->save();
                return redirect()->route('users.edit', $user->id)->with('message', '绑定成功');
            } else {
                return redirect()->route('root');
            }
        } else {
            $user = User::where('github_id', $github_user->id)->first();
            if ($user) { // 已绑定，直接登录
                Auth::login($user);
                $request->session()->regenerate();
                return redirect()->route('root');

            } else {
                $user = User::where('email', $github_user->email)->first();

                if (!$user) { // 邮箱未注册，注册账号并登录
                    $github_user = User::create([
                        'name' => $github_user->name,
                        'email' => $github_user->email,
                        'password' => 'from_oauth',
                        'github_id' => $github_user->id,
                        'github_name' => $github_user->username,
                        'avatar' => $github_user->avatar,
                    ]);
                    Auth::login($github_user);
                    $request->session()->regenerate();
                    return redirect()->route('root');
                } else { // 邮箱已被注册，不能新建账号
                    return redirect()->route('login')->with('danger', '此github账号的邮箱已注册，请用邮箱登录后再进行绑定');
                }

            }
        }
    }

    public function unbind()
    {
        $user = Auth::user();
        if ($user->github_id) {
            $user->github_id = null;
            $user->save();
            return redirect()->route('users.edit', $user->id)->with('message', '解绑成功');
        }
        return redirect()->route('users.edit', $user->id);
    }
}
