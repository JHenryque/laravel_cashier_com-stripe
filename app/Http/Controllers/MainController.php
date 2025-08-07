<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
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
            "longest" => Crypt::encryptString(env('STRIPE_PRODUCT_ID') . "|" . env('STRIPE_LONGEST_PRICE_ID')),
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

        $plan = explode("|", $plan);
        $product_id = $plan[0];
        $price_id = $plan[1];

        return auth()->user()
            ->newSubscription($product_id, $price_id)
            ->checkout([
                'success_url' => route('subscription.success'),
                'cancel_url' => route('plans'),
            ]);
    }

    public function subscriptionSuccess()
    {

//        $data = Carbon::now();
//        $data->setTime(0, 1, 30);
//
//        if ($data == Carbon::now()) {
//            return redirect()->route('plans');
//        }

        return view('subscription_success');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
