<?php

namespace App\Http\Middleware;

use Gloudemans\Shoppingcart\Facades\Cart;
use Closure;
use Illuminate\Http\Request;

class CheckoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Cart::count()) {
            return $next($request);
        }
        return redirect()->route('shop.index');
    }
}