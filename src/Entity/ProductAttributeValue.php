<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'product_attribute_values')]
class ProductAttributeValue
{

    #[ORM\Id]
    #[ORM\Column(type: "string")]
    private string $id;

    #[ORM\Column(type: "string")]
    private string $value;

    #[ORM\Column(name: "display_value", type: "string")]
    private string $displayValue;

    #[ORM\Column(type: "integer")]
    private int $position;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'product_attribute_values')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', columnDefinition: "VARCHAR(255)")]

    private ?Product $product = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: ProductAttribute::class, inversedBy: 'product_attribute_values')]
    #[ORM\JoinColumn(name: 'product_attribute_id', referencedColumnName: 'id', nullable: false)]
    private ?ProductAttribute $productAttribute = null;

    // Inside ProductAttributeValue class
    #[ORM\OneToMany(mappedBy: "product_attribute_value", targetEntity: OrderItemAttribute::class)]
    private Collection $order_item_attributes;

    public function __construct(string $id, string $value, string $displayValue, int $position)
    {
        $this->id = $id;
        $this->value = $value;
        $this->displayValue = $displayValue;
        $this->position = $position;
        $this->order_item_attributes = new ArrayCollection();
    }
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function setProductAttribute(ProductAttribute $productAttribute)
    {
        $this->productAttribute = $productAttribute;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDisplayValue()
    {
        return $this->displayValue;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getPosition()
    {
        return $this->position;
    }
}
