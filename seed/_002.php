<?php

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Currency;
use App\Entity\Price;
use App\Entity\Product;
use App\Entity\ProductAttribute;
use App\Entity\ProductAttributeValue;
use App\Entity\ProductContent;

require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../bootstrap.php';

$json = file_get_contents(__DIR__ . "/data.json");
$json_data = json_decode($json, true);
$data = $json_data["data"];
$products = $data["products"];



function getProductCategory(string $category_id, $entityManager): object |null
{

    $categoryRepository = $entityManager->getRepository(Category::class);

    $category = $categoryRepository->find($category_id);

    if (!$category) {
        echo "Error: Category 'Electronics' not found. Please seed categories first.\n";
        return null;
    }

    return $category;
}

function getProductBrand(string $brand_id, $entityManager): object |null
{

    $brandRepository = $entityManager->getRepository(Brand::class);

    $brand = $brandRepository->find($brand_id);

    if (!$brand) {
        echo "Error: Category 'Electronics' not found. Please seed categories first.\n";
        return null;
    }

    return $brand;
}

function getCurrency(string $id, $entityManager): object |null
{

    $currencyRepository = $entityManager->getRepository(Currency::class);

    $currency = $currencyRepository->find($id);

    if (!$currency) {
        echo "Error: Currency not found.\n";
        return null;
    }

    return $currency;
}

foreach ($products as $product) {
    $category = getProductCategory($product["category"], $entityManager);
    $brand  = getProductBrand($product["brand"], $entityManager);

    if (!$category || !$brand) {
        continue;
    }

    $new_product = new Product($product["id"], $product["name"], $product["inStock"], $product["description"]);
    $new_product->setCategory($category);
    $new_product->setBrand($brand);

    $entityManager->persist($new_product);

    $gallery = $product["gallery"];

    foreach ($gallery as $key => $value) {
        if (!$value) {
            continue;
        }
        $new_picture = new ProductContent($key, $value);
        $new_picture->setProduct($new_product);
        $entityManager->persist($new_picture);
    }
    $prices = $product["prices"];

    foreach ($prices as $price) {

        $currency = getCurrency("USD", $entityManager);

        if (!$currency) {
            continue;
        }

        $new_price = new Price($price["amount"]);
        $new_price->setCurrency($currency);
        $new_price->setProduct($new_product);
        $entityManager->persist($new_price);
    }

    $attributes = $product["attributes"];

    foreach ($attributes as $attribute) {
        $new_attribute = new ProductAttribute($attribute["id"]);
        $new_attribute->setProduct($new_product);
        $entityManager->persist($new_attribute);

        $attribute_items = $attribute["items"];

        foreach ($attribute_items as $key => $value) {
            $new_attribute_item = new ProductAttributeValue($value["id"], $value["value"], $value["displayValue"], $key);

            $new_attribute_item->setProduct($new_product);
            $new_attribute_item->setProductAttribute($new_attribute);
            $entityManager->persist($new_attribute_item);
        }
    }
}

$entityManager->flush();

echo "Products seeded successfully\n";
