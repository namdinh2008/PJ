<?php

namespace App\Helpers;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistHelper
{
    /**
     * Check if a product is in user's wishlist
     */
    public static function isInWishlist($productId)
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->exists();
        } else {
            $wishlist = session()->get('wishlist', []);
            return in_array($productId, $wishlist);
        }
    }

    /**
     * Get wishlist count for current user
     */
    public static function getWishlistCount()
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())->count();
        } else {
            $wishlist = session()->get('wishlist', []);
            return count($wishlist);
        }
    }

    /**
     * Get wishlist items for current user
     */
    public static function getWishlistItems()
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())
                ->with(['product'])
                ->get();
        } else {
            $wishlistIds = session()->get('wishlist', []);
            if (empty($wishlistIds)) {
                return collect();
            }
            
            $products = \App\Models\Product::whereIn('id', $wishlistIds)->get();
            return $products->map(function ($product) {
                return (object) [
                    'id' => 'session_' . $product->id,
                    'product' => $product,
                    'created_at' => now()
                ];
            });
        }
    }
} 