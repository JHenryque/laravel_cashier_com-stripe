<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
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
        return $user;
    }

    // criado no Stripe um catalogo de produto
    public function plans():View
    {
        $prices = [
            "monthly" => Crypt::encryptString(env('STRIPE_PRODUCT_ID') . "|" . env('STRIPE_MONTHLY_PRICE_ID')),
            "yearly" => Crypt::encryptString(env('STRIPE_PRODUCT_ID') . "|" . env('STRIPE_YEARLY_PRICE_ID')),
            "longest" => Crypt::encryptString(env('STRIPE_PRODUCT_ID') . "|" . env('STRIPE_LONG_PRICE_ID')),
        ];

        return view('plans', compact('prices'));
    }

    public function planSelected($id)
    {
        // check if $id is valid
        $plan = Crypt::decryptString($id);
        if (!$plan) {
            return redirect()->route('plans');
        }

        $data = explode("|", $plan);
        echo "Product ID: " . $data[0] . "<b>";
        echo "Price: " . $data[1] . "<b>";

        return $data;
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
