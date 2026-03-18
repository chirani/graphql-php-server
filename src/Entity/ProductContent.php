<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'product_contents')]
class ProductContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: 'integer')]
    private int $position;

    #[ORM\Column(type: "string")]
    private string $product_content_uri;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'product_contents')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id', nullable: false)]
    private ?Product $product = null;

    public function __construct(int $position, string $product_content_uri)
    {
        $this->position = $position;
        $this->product_content_uri = $product_content_uri;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
    }
}
