<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Http\Controllers\User\CartController;
use App\Models\CartItem;
use Illuminate\Http\Request;

echo "=== Testing CartController Update ===\n";

// Find a cart item to test with
$cartItem = CartItem::with(['product', 'color'])->first();
if (!$cartItem) {
    echo "No cart items found!\n";
    exit;
}

echo "Testing with cart item ID: {$cartItem->id}\n";
echo "Current color_id: " . ($cartItem->color_id ?? 'null') . "\n";

// Create a mock request
$request = new Request();
$request->merge(['color_id' => 7]); // Test with color ID 7
$request->headers->set('Accept', 'application/json');
$request->headers->set('X-Requested-With', 'XMLHttpRequest');

// Test the controller
try {
    $controller = new CartController();
    $response = $controller->update($request, $cartItem);
    
    echo "Response status: " . $response->getStatusCode() . "\n";
    echo "Response content: " . $response->getContent() . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
} 