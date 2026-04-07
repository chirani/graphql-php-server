<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'boolean')]
    private bool $inStock;

    #[ORM\Column(type: 'string', columnDefinition: "Text")]
    private string $description;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductContent::class)]
    private Collection $productContents;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Price::class)]
    private Collection $prices;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductAttribute::class)]
    private Collection $productAttributes;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: OrderItem::class)]
    private Collection $orderItems;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id', columnDefinition: "VARCHAR(255)")]
    private ?Category $category = null;

    #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'products')]
    #[ORM\JoinColumn(name: 'brand_id', referencedColumnName: 'id', columnDefinition: "VARCHAR(255)")]
    private ?Brand $brand = null;

    public function __construct(string $id, string $name, bool $inStock, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->inStock = $inStock;
        $this->description = $description;
        $this->productContents = new ArrayCollection();
        $this->orderItems = new ArrayCollection();
    }

    public function getCategory(): string
    {
        $category = $this->category;
        return $category->getId();
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function setBrand(Brand $brand): void
    {
        $this->brand = $brand;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isInStock(): string
    {
        return $this->inStock;
    }


    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function getProductAttributes(): Collection
    {
        return $this->productAttributes;
    }

    public function getProductContents(): array
    {
        $result = [];
        foreach ($this->productContents as $productContent) {
            $result[$productContent->getPosition()] = $productContent->getProductContentUri();
        }
        return $result;
    }

    public function getBrandName(): string
    {
        return  $this->brand->getName();
    }
}
