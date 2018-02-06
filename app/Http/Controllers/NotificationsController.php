<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(20);
        $user->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
