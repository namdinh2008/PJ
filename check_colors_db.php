<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\CarVariantColor;

echo "=== Car Variant Colors in Database ===\n";
$colors = CarVariantColor::all(['id', 'color_name']);
foreach ($colors as $color) {
    echo "ID: {$color->id}, Name: '{$color->color_name}'\n";
}

echo "\n=== Testing validation ===\n";
$testIds = [1, 7, 8, 15, 999];
foreach ($testIds as $id) {
    $exists = CarVariantColor::where('id', $id)->exists();
    echo "ID {$id}: " . ($exists ? 'EXISTS' : 'NOT EXISTS') . "\n";
} 