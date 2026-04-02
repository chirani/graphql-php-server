<?php

namespace App\MyGraphql\InputTypes;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class OrderItemAttributeInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'OrderItemAttributeInput',
            'fields' => [
                'attributeId' => Type::nonNull(Type::string()),
                'attributeValueId' => Type::nonNull(Type::string()),
            ]
        ]);
    }
}
