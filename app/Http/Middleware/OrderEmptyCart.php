<?php

namespace App\Http\Middleware;

use App\Http\Helpers\Cart;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderEmptyCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Cart::isEmptyCart()){
            return redirect('/');
        }
        return $next($request);
    }
}
