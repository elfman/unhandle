<?php

namespace App\Observers;

use App\Models\User;
use Identicon\Generator\SvgGenerator;
use Identicon\Identicon;

class UserObserver
{
    public function creating(User $user)
    {
//        if (empty($user->avatar)) {
//            $identicon = new Identicon(new SvgGenerator());
//            $user->avatar = $identicon->getImageDataUri($user->email);
//        }
    }
}