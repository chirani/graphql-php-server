<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\Proxy;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $id;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id', nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(type: 'boolean')]
    private bool $inStock;

    #[ORM\Column(type: 'string')]
    private string $description;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: ProductContent::class)]
    private Collection $productContents;

    public function __construct(string $id, string $name, bool $inStock, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->inStock = $inStock;
        $this->description = $description;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
        $this->productContents = new ArrayCollection();
    }
}
