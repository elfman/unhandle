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