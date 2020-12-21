<?php

namespace App\Listeners;

use App\Models\Coupon;
// use App\Jobs\UpdateCoupon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartUpdatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (isset(session()->get('coupon')['name'])) {
            $coupon = Coupon::where('code', session()->get('coupon')['name'])->first();

            session()->put('coupon', [
                'name'=>$coupon->code,
                'discount'=>$coupon->discount(Cart::subtotal()),
            ]);
        }
    }
}
