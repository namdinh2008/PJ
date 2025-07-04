<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WishlistController extends Controller
{
    /**
     * Display the user's wishlist
     */
    public function index()
    {
        if (Auth::check()) {
            // For authenticated users, get from database
            $wishlistItems = Wishlist::where('user_id', Auth::id())
                ->with(['product'])
                ->get();
        } else {
            // For guest users, get from session
            $wishlistIds = session()->get('wishlist', []);
            $wishlistItems = collect();
            
            if (!empty($wishlistIds)) {
                $products = Product::whereIn('id', $wishlistIds)->get();
                $wishlistItems = $products->map(function ($product) {
                    return (object) [
                        'id' => 'session_' . $product->id,
                        'product' => $product,
                        'created_at' => now()
                    ];
                });
            }
        }

        return view('user.wishlist.index', compact('wishlistItems'));
    }

    /**
     * Add item to wishlist
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $productId = $request->input('product_id');

        try {
            if (Auth::check()) {
                // For authenticated users, save to database
                $existingWishlist = Wishlist::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

                if (!$existingWishlist) {
                    Wishlist::create([
                        'user_id' => Auth::id(),
                        'product_id' => $productId
                    ]);
                }
            } else {
                // For guest users, save to session
                $wishlist = session()->get('wishlist', []);
                
                if (!in_array($productId, $wishlist)) {
                    $wishlist[] = $productId;
                    session()->put('wishlist', $wishlist);
                }
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đã thêm vào yêu thích!',
                    'wishlist_count' => $this->getWishlistCount()
                ]);
            }

            return redirect()->back()->with('success', 'Đã thêm vào yêu thích!');

        } catch (\Exception $e) {
            Log::error('Error adding to wishlist:', ['error' => $e->getMessage()]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi thêm vào yêu thích'
                ], 500);
            }

            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm vào yêu thích');
        }
    }

    /**
     * Remove item from wishlist
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $productId = $request->input('product_id');

        try {
            if (Auth::check()) {
                // For authenticated users, remove from database
                Wishlist::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->delete();
            } else {
                // For guest users, remove from session
                $wishlist = session()->get('wishlist', []);
                $wishlist = array_diff($wishlist, [$productId]);
                session()->put('wishlist', array_values($wishlist));
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đã xóa khỏi yêu thích!',
                    'wishlist_count' => $this->getWishlistCount()
                ]);
            }

            return redirect()->back()->with('success', 'Đã xóa khỏi yêu thích!');

        } catch (\Exception $e) {
            Log::error('Error removing from wishlist:', ['error' => $e->getMessage()]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi xóa khỏi yêu thích'
                ], 500);
            }

            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa khỏi yêu thích');
        }
    }

    /**
     * Clear all wishlist items
     */
    public function clear(Request $request)
    {
        try {
            if (Auth::check()) {
                // For authenticated users, clear from database
                Wishlist::where('user_id', Auth::id())->delete();
            } else {
                // For guest users, clear from session
                session()->forget('wishlist');
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đã xóa toàn bộ yêu thích!',
                    'wishlist_count' => 0
                ]);
            }

            return redirect()->back()->with('success', 'Đã xóa toàn bộ yêu thích!');

        } catch (\Exception $e) {
            Log::error('Error clearing wishlist:', ['error' => $e->getMessage()]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi xóa yêu thích'
                ], 500);
            }

            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa yêu thích');
        }
    }

    /**
     * Check if product is in wishlist
     */
    public function check(Request $request)
    {
        $productId = $request->input('product_id');
        $isInWishlist = false;

        if (Auth::check()) {
            $isInWishlist = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->exists();
        } else {
            $wishlist = session()->get('wishlist', []);
            $isInWishlist = in_array($productId, $wishlist);
        }

        return response()->json([
            'is_in_wishlist' => $isInWishlist
        ]);
    }

    /**
     * Get wishlist count for header
     */
    public function getCount()
    {
        $count = $this->getWishlistCount();
        return response()->json([
            'success' => true,
            'wishlist_count' => $count
        ]);
    }

    /**
     * Helper method to get wishlist count
     */
    private function getWishlistCount()
    {
        if (Auth::check()) {
            return Wishlist::where('user_id', Auth::id())->count();
        } else {
            $wishlist = session()->get('wishlist', []);
            return count($wishlist);
        }
    }

    /**
     * Move session wishlist to database when user logs in
     */
    public function migrateSessionWishlist()
    {
        if (Auth::check()) {
            $sessionWishlist = session()->get('wishlist', []);
            
            if (!empty($sessionWishlist)) {
                foreach ($sessionWishlist as $productId) {
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
                
                session()->forget('wishlist');
            }
        }
    }
}