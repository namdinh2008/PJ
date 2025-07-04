<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $userId = \Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->id : null;
        $sessionId = session()->getId();

        $cartItems = CartItem::where(function ($q) use ($userId, $sessionId) {
            if ($userId) $q->where('user_id', $userId);
            else $q->where('session_id', $sessionId);
        })->with(['product', 'color'])->get();

        // Load carVariant colors separately for products that are car variants
        foreach ($cartItems as $item) {
            if ($item->product->product_type === 'car_variant') {
                $item->product->load('carVariant.colors');
            }
        }

        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        // Debug: Log the request data
        Log::info('Cart add request:', $request->all());
        
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'color_id' => 'nullable|exists:car_variant_colors,id',
            'quantity' => 'required|integer|min:1'
        ]);
        $userId = Auth::check() ? Auth::user()->id : null;
        $sessionId = session()->getId();

        try {
            $cartItem = CartItem::where([
                'product_id' => $request->product_id,
                'color_id' => $request->color_id,
                'user_id' => $userId,
                'session_id' => $sessionId,
            ])->first();

            if ($cartItem) {
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
                Log::info('Updated existing cart item', ['cart_item_id' => $cartItem->id]);
            } else {
                $newCartItem = CartItem::create([
                    'product_id' => $request->product_id,
                    'color_id' => $request->color_id,
                    'quantity' => $request->quantity,
                    'user_id' => $userId,
                    'session_id' => $sessionId,
                ]);
                Log::info('Created new cart item', ['cart_item_id' => $newCartItem->id]);
            }
        } catch (\Exception $e) {
            Log::error('Error adding to cart:', ['error' => $e->getMessage()]);
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra khi thêm vào giỏ hàng'], 500);
            }
            return back()->with('error', 'Có lỗi xảy ra khi thêm vào giỏ hàng');
        }

        // Nếu là AJAX request, trả về JSON
        if ($request->ajax()) {
            $cartCount = CartItem::where(function ($q) use ($userId, $sessionId) {
                if ($userId) $q->where('user_id', $userId);
                else $q->where('session_id', $sessionId);
            })->sum('quantity'); // Đổi từ count() sang sum('quantity')

            return response()->json([
                'success' => true,
                'cart_count' => $cartCount,
                'message' => 'Đã thêm vào giỏ hàng!'
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        // Debug: Log the request data
        Log::info('Cart update request:', $request->all());
        
        try {
            $request->validate([
                'quantity' => 'nullable|integer|min:1',
                'color_id' => 'nullable|exists:car_variant_colors,id'
            ]);

            $updateData = [];
            if ($request->has('quantity')) {
                $updateData['quantity'] = $request->quantity;
                Log::info('Updating quantity:', ['quantity' => $request->quantity]);
            }
            if ($request->has('color_id')) {
                $updateData['color_id'] = $request->color_id;
                Log::info('Updating color_id:', ['color_id' => $request->color_id]);
            }

            Log::info('Update data:', $updateData);
            $cartItem->update($updateData);
            Log::info('Cart item updated successfully');
            
            // Reload the cart item with relationships
            $cartItem->load(['product', 'color']);
            Log::info('Cart item reloaded with relationships');

            if ($request->ajax()) {
                $userId = Auth::check() ? Auth::user()->id : null;
                $sessionId = session()->getId();
                $cartCount = CartItem::where(function ($q) use ($userId, $sessionId) {
                    if ($userId) $q->where('user_id', $userId);
                    else $q->where('session_id', $sessionId);
                })->sum('quantity');
                
                $itemTotal = $cartItem->product->price * $cartItem->quantity;
                $colorName = $cartItem->color ? $cartItem->color->color_name : null;
                
                $response = [
                    'success' => true,
                    'cart_count' => $cartCount,
                    'item_total' => $itemTotal,
                    'quantity' => $cartItem->quantity,
                    'color_id' => $cartItem->color_id,
                    'color_name' => $colorName,
                    'message' => $request->has('color_id') ? 'Cập nhật màu sắc thành công!' : 'Cập nhật số lượng thành công!'
                ];
                
                // Debug: Log the response
                Log::info('Cart update response:', $response);
                
                return response()->json($response, 200, ['Content-Type' => 'application/json']);
            }
            return back()->with('success', 'Cập nhật thành công!');
        } catch (\Exception $e) {
            Log::error('Error in cart update:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi cập nhật: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Có lỗi xảy ra khi cập nhật: ' . $e->getMessage());
        }
    }

    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        
        if (request()->ajax()) {
            $userId = Auth::check() ? Auth::user()->id : null;
            $sessionId = session()->getId();
            $cartCount = CartItem::where(function ($q) use ($userId, $sessionId) {
                if ($userId) $q->where('user_id', $userId);
                else $q->where('session_id', $sessionId);
            })->sum('quantity');
            
            return response()->json([
                'success' => true,
                'cart_count' => $cartCount,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!'
            ]);
        }
        
        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function clear(Request $request)
    {
        $userId = Auth::check() ? Auth::user()->id : null;
        $sessionId = session()->getId();
        \App\Models\CartItem::where(function ($q) use ($userId, $sessionId) {
            if ($userId) $q->where('user_id', $userId);
            else $q->where('session_id', $sessionId);
        })->delete();
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => 0,
                'message' => 'Đã xóa toàn bộ giỏ hàng!'
            ]);
        }
        
        return back()->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }

    public function getCount(Request $request)
    {
        $userId = Auth::check() ? Auth::user()->id : null;
        $sessionId = session()->getId();
        
        $cartCount = CartItem::where(function ($q) use ($userId, $sessionId) {
            if ($userId) $q->where('user_id', $userId);
            else $q->where('session_id', $sessionId);
        })->sum('quantity');

        return response()->json([
            'success' => true,
            'cart_count' => $cartCount
        ]);
    }

    public function showCheckoutForm(Request $request)
    {
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $sessionId = session()->getId();

        $cartItems = CartItem::where(function ($q) use ($userId, $sessionId) {
            if ($userId) $q->where('user_id', $userId);
            else $q->where('session_id', $sessionId);
        })->with(['product', 'color'])->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('cart.checkout', compact('cartItems', 'total', 'user'));
    }

    public function processCheckout(Request $request)
    {
        $user = Auth::user();
        $userId = $user ? $user->id : null;
        $sessionId = session()->getId();

        $cartItems = CartItem::where(function ($q) use ($userId, $sessionId) {
            if ($userId) $q->where('user_id', $userId);
            else $q->where('session_id', $sessionId);
        })->with(['product', 'color'])->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $validated = $request->validate([
            'phone' => 'required|string',
            'name' => 'required|string',
            'email' => 'nullable|email',
            'address' => 'required|string',
            'note' => 'nullable|string',
            'payment_method' => 'required|in:cod,bank_transfer,vnpay,momo',
        ]);

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $order = Order::create([
            'user_id' => $userId,
            'phone' => $validated['phone'],
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'address' => $validated['address'],
            'total_price' => $total,
            'note' => $validated['note'] ?? null,
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'color_id' => $item->color_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Xóa giỏ hàng
        CartItem::where(function ($q) use ($userId, $sessionId) {
            if ($userId) $q->where('user_id', $userId);
            else $q->where('session_id', $sessionId);
        })->delete();

        return redirect()->route('cart.index')->with('success', 'Đặt hàng thành công!');
    }
}
