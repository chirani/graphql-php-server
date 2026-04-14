<?php

namespace App\MyGraphql\ObjectTypes;

use App\Entity\ProductAttributeValue;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductAttributeValueType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'ProductAttributeValue',
            'fields' => [
                "id" => [
                    'type' => Type::string(),
                    'resolve' => fn(ProductAttributeValue $productAttributeValue) => $productAttributeValue->getId()
                ],
                "value" => [
                    'type' => Type::string(),
                    'resolve' => fn(ProductAttributeValue $productAttributeValue) => $productAttributeValue->getValue()
                ],
                "displayValue" => [
                    'type' => Type::string(),
                    'resolve' => fn(ProductAttributeValue $productAttributeValue) => $productAttributeValue->getDisplayValue()
                ],
                "position" => [
                    'type' => Type::int(),
                    'resolve' => fn(ProductAttributeValue $productAttributeValue) => $productAttributeValue->getPosition()
                ]
            ]
        ]);
    }
}
