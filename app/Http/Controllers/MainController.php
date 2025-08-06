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
            echo "Logado com sucesso! <br><hr>" . "<h2>" . auth()->user()->name . "</h2>";
        }
    }
}
