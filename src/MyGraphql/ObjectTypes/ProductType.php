<?php

namespace App\MyGraphql\ObjectTypes;

use App\Entity\Product;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            "name" => "Product",
            "fields" => [
                'id' => [
                    'type' => Type::string(),
                    'resolve' => fn(Product $product) => $product->getId()
                ],
                'name' => [
                    'type' => Type::string(),
                    'resolve' => fn(Product $product) => $product->getName()
                ],
                'category' => [
                    'type' => Type::string(),
                    'resolve' => fn(Product $product) => $product->getCategory()
                ]
            ]
        ]);
    }
}
