<?php

namespace App\MyGraphql\ObjectTypes;

use App\Entity\ProductAttribute;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductAttributeType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'ProductAttribute',
            'fields' => [
                "id" => [
                    'type' => Type::string(),
                    'resolve' => fn(ProductAttribute $productAttribute) => $productAttribute->getSid()
                ],
                "items" => [
                    'type' => Type::listOf(new ProductAttributeValueType()),
                    "resolve" => fn(ProductAttribute $productAttribute) => $productAttribute->getProductAttributeValue()
                ]
            ]
        ]);
    }
}
