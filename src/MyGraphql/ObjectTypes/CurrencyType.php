<?php

namespace App\MyGraphql\ObjectTypes;

use App\Entity\Currency;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CurrencyType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Currency',
            'fields' => [
                "id" => [
                    'type' => Type::string(),
                    'resolve' => fn(Currency $currency) => $currency->getId()
                ],
                "label" => [
                    'type' => Type::string(),
                    'resolve' => fn(Currency $currency) => $currency->getLabel()
                ],
                "symbol" => [
                    'type' => Type::string(),
                    'resolve' => fn(Currency $currency) => $currency->getSymbol()
                ]

            ]
        ]);
    }
}
