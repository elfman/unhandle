<?php
/**
 * Created by PhpStorm.
 * User: luoxiongwen
 * Date: 2018/1/29
 * Time: 上午10:49
 */

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function avatarAttr($user = null)
{
    $user = $user ?: Auth::user();
    return $user->avatar === null ? "identicon=$user->email" :"src=$user->avatar";
}