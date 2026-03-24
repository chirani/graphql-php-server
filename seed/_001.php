<?php

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Currency;

require_once __DIR__ . '/../bootstrap.php';

$json = file_get_contents(__DIR__ . "/data.json");
$json_data = json_decode($json, true);
$data = $json_data["data"];
$categories = $data["categories"];
$currencies = $data["currencies"];
$products = $data["products"];

foreach ($categories as $category) {

    $new_category = new Category($category["name"], $category["name"]);

    $entityManager->persist($new_category);
}

foreach ($currencies as $currency) {
    $new_currency = new Currency($currency["label"], $currency["symbol"]);
    $entityManager->persist($new_currency);
}


$uniqueBrands = [];

foreach ($products as $product) {
    if (!$product["brand"]) {
        continue;
    }
    $uniqueBrands[$product["brand"]] = $product["brand"];
}

$uniqueBrands = array_values($uniqueBrands);

foreach ($uniqueBrands as $brand) {

    $new_brand = new Brand($brand, $brand);
    $entityManager->persist($new_brand);
}

$entityManager->flush();

echo "Categories seeded successfully\n";
