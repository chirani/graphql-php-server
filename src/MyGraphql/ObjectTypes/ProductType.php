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
                ],
                'description' => [
                    'type' => Type::string(),
                    'resolve' => fn(Product $product) => $product->getDescription()
                ],
                'inStock' => [
                    'type' => Type::boolean(),
                    'resolve' => fn(Product $product) => $product->isInStock()
                ],
                "attributes" => [
                    'type' =>  Type::listOf(new ProductAttributeType()),
                    'resolve' => fn(Product $product) => $product->getProductAttributes()
                ],
                "gallery" => [
                    'type' => Type::listOf(Type::string()),
                    'resolve' => fn(Product $product) => $product->getProductContents()
                ],
                'prices' => [
                    'type' => Type::listOf(new PriceType()),
                    'resolve' => fn(Product $product) => $product->getPrices()
                ],
                'brand' => [
                    'type' => Type::string(),
                    'resolve' => fn(Product $product) => $product->getBrandName()
                ]
            ]
        ]);
    }
}
