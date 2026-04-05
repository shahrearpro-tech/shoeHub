<?php
$service = new \App\Services\ProductService();
$cat = \App\Models\Category::first();
$brand = \App\Models\Brand::first();

if (!$cat) {
    die("No Category found. Please create one first.");
}
if (!$brand) {
    die("No Brand found. Please create one first.");
}

$data = [
    'name' => 'Tinker Test Product ' . time(),
    'category_id' => $cat->id,
    'brand_id' => $brand->id,
    'regular_price' => 1200,
    'sale_price' => 1100,
    'stock_quantity' => 50,
    'sku' => 'TINKER-VAR-' . time(),
    'product_type' => 'variable',
    'sizes' => '40, 41, 42',
    'colors' => 'Red, Blue, Green',
    'description' => 'Tested via tinker script',
    'slug' => 'tinker-test-' . time(),
];

try {
    $product = $service->createProduct($data);
    echo "SUCCESS! Product ID: " . $product->id . "\n";
    echo "Attributes Count: " . $product->attributes()->count() . "\n";
    foreach($product->attributes as $attr) {
        echo "- " . $attr->attribute_name . ": " . $attr->attribute_value . "\n";
    }
} catch (\Exception $e) {
    echo "FAILED: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
