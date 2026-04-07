<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'product_attributes')]
class ProductAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string")]
    private string $sid;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'product_attributes')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', columnDefinition: "VARCHAR(255)")]

    private ?Product $product = null;


    #[ORM\OneToMany(mappedBy: 'productAttribute', targetEntity: ProductAttributeValue::class)]
    private Collection $productAttributeValues;


    public function __construct(string $sid)
    {
        $this->sid = $sid;
        $this->productAttributeValues = new ArrayCollection();
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    public function getSid()
    {
        return $this->sid;
    }

    public function getProductAttributeValue()
    {
        return $this->productAttributeValues;
    }
}
