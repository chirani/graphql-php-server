<?php

use App\Entity\Category;

require_once __DIR__ . '/../bootstrap.php';

$json = file_get_contents(__DIR__ . "/data.json");
$json_data = json_decode($json, true);
$data = $json_data["data"];
$categories = $data["categories"];

foreach ($categories as $category) {

    $new_category = new Category($category["name"], $category["name"]);

    $entityManager->persist($new_category);
}

$entityManager->flush();

echo "Categories seeded successfully\n";
