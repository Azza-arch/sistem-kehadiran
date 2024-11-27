<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    //

    public function userReport($userId)
    {
        $user = User::with('attend')->findOrFail($userId);
        return view('attendance-report', compact('user'));
    }

    public function createUser()
    {
        return view('user-info');
    }
    public function userInfo($userId)
    {
        $user = User::findOrFail($userId);
        // dd($user);
        return view('user-info-edit', compact('user'));
    }
}
