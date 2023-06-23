<?php

namespace App\Http\Controllers;

use App\Models\MessengerUsers;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MessengerUserController extends Controller
{
    public function index(): View
    {
        $messengerUsers = MessengerUsers::all();
        return view('messengerUser',compact('messengerUsers'));
    }
}
