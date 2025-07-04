<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class MigrateWishlist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has session wishlist
        if (Auth::check() && session()->has('wishlist')) {
            $sessionWishlist = session()->get('wishlist', []);
            
            if (!empty($sessionWishlist)) {
                foreach ($sessionWishlist as $productId) {
                    // Check if product exists and is not already in user's wishlist
                    $existingWishlist = Wishlist::where('user_id', Auth::id())
                        ->where('product_id', $productId)
                        ->first();

                    if (!$existingWishlist) {
                        Wishlist::create([
                            'user_id' => Auth::id(),
                            'product_id' => $productId
                        ]);
                    }
                }
                
                // Clear session wishlist after migration
                session()->forget('wishlist');
            }
        }

        return $next($request);
    }
} 