<?php

namespace App\Entity;

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'brands')]
class Brand
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private string $id;

    #[ORM\Column(type: 'string', unique: true)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Product::class)]
    private Collection $products;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->products = new ArrayCollection();
    }

    public function getName()
    {
        return $this->name;
    }
}
