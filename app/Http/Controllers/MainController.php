<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends Controller
{
    //
    public function loginPage():View
    {
        return view('login');
    }

    public function loginSubmit($id)
    {
        // direct login
        $user = User::findOrFail($id);
        if ($user) {
            auth()->login($user);
            return redirect()->route('plans');
        }
    }

    public function plans():View
    {
        return view('plans');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
