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

    #[ORM\ManyToOne(targetEntity: OrderItem::class, inversedBy: "order_item_attributes")]
    #[ORM\JoinColumn(name: "order_item_id", referencedColumnName: "id")]
    private OrderItem $orderItem;

    #[ORM\ManyToOne(targetEntity: ProductAttribute::class, inversedBy: "order_item_attributes")]
    #[ORM\JoinColumn(name: "attribute_id", referencedColumnName: "id")]
    private ProductAttribute $attribute;

    #[ORM\ManyToOne(targetEntity: ProductAttributeValue::class, inversedBy: "order_item_attributes")]
    #[ORM\JoinColumn(
        name: "attribute_value_id",
        referencedColumnName: "id",
        nullable: true,
        columnDefinition: "VARCHAR(255)"
    )]
    private ?ProductAttributeValue $attributeValue = null;

    public function __construct() {}

    public function setOrderItem(OrderItem $orderItem)
    {
        $this->orderItem = $orderItem;
    }

    public function setProductAttribute(ProductAttribute $attribute)
    {
        $this->attribute = $attribute;
    }

    public function setProductAttributeValue(ProductAttributeValue $attributeValue)
    {
        $this->attributeValue = $attributeValue;
    }
}
