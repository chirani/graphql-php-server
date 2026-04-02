<?php

namespace App\Entity;

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

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'product_attribute_values')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', nullable: false)]
    private ?Product $product = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: ProductAttribute::class, inversedBy: 'product_attribute_values')]
    #[ORM\JoinColumn(name: 'product_attribute_id', referencedColumnName: 'id', nullable: false)]
    private ?ProductAttribute $productAttribute = null;

    public function __construct(string $id, string $value, string $displayValue)
    {
        $this->id = $id;
        $this->value = $value;
        $this->displayValue = $displayValue;
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
}
