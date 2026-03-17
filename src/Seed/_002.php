<?php

use App\Entity\Category;
use App\Entity\Product;

require_once __DIR__ . '/vendor/autoload.php';

$json = file_get_contents(__DIR__ . "/data.json");
$json_data = json_decode($json, true);
$data = $json_data["data"];
$products = $data["products"];



function getProductCategory(string $category_id): object |null
{
    require_once __DIR__ . "/../../bootstrap.php";

    $categoryRepository = $entityManager->getRepository(Category::class);

    $category = $categoryRepository->find($category_id);

    if (!$category) {
        echo "Error: Category 'Electronics' not found. Please seed categories first.\n";
        return null;
    }

    return $category;
}

foreach ($products as $product) {
    $category = getProductCategory($product["category"]);
    if ($category == null) {
        continue;
    }

    $new_product = new Product($product["id"], $product["name"]);
    $new_product->setCategory($category);

    $entityManager->persist($new_product);
}

$entityManager->flush();
