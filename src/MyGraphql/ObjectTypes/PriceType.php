<?php

namespace App\MyGraphql\ObjectTypes;

use App\Entity\Price;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PriceType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Price',
            'fields' => [
                "id" => [
                    'type' => Type::string(),
                    'resolve' => fn(Price $price) => $price->getId()
                ],
                "amount" => [
                    'type' => Type::float(),
                    'resolve' => fn(Price $price) => $price->getAmount()
                ],
                "currency" => [
                    'type' => new CurrencyType(),
                    'resolve' => fn(Price $price) => $price->getCurrency()
                ]
            ]
        ]);
    }
}
