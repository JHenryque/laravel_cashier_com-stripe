<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class noSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if the user has no subscription
        if (auth()->user()->subscribed(env('STRIPE_PRODUCT_ID'))) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
