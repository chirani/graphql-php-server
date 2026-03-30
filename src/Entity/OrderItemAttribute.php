<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name: "order_item_attributes")]
class OrderItemAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: OrderItem::class, inversedBy: "attributes")]
    #[ORM\JoinColumn(name: "order_item_id", referencedColumnName: "id")]
    private OrderItem $orderItem;

    #[ORM\ManyToOne(targetEntity: ProductAttribute::class)]
    #[ORM\JoinColumn(name: "attribute_id", referencedColumnName: "id")]
    private ProductAttribute $attribute;

    #[ORM\ManyToOne(targetEntity: ProductAttributeValue::class)]
    #[ORM\JoinColumn(name: "attribute_value_id", referencedColumnName: "id")]
    private ProductAttributeValue $attributeValue;

    public function __construct(
        OrderItem $orderItem,
        ProductAttribute $attribute,
        ProductAttributeValue $attributeValue
    ) {
        $this->orderItem = $orderItem;
        $this->attribute = $attribute;
        $this->attributeValue = $attributeValue;
    }
}
