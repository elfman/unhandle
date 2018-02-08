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
    if (is_array($user)) {
        $user = (object)$user;
    }
    return $user->avatar === null ? "identicon=$user->email" : "src=$user->avatar";
}

function getTextBrief($text)
{
    $text = substr($text, 0, min(strlen($text), 300));
    return strip_tags((new Parsedown())->text($text));
}

function heOrMe($user) {
    return $user->id === Auth::id() ? '我' : 'Ta ';
}

function shortenNumber($num)
{
    if ($num < 1000) {
        return $num;
    }

    return number_format($num / 1000, 1). 'k';
}