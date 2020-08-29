<?php

namespace App\Entity;

use App\Repository\OrderProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderProductRepository::class)
 */
class OrderProduct
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="orderProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $linkedOrder;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $cost;


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product|null $product
     * @return $this
     */
    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Order|null
     */
    public function getLinkedOrder(): ?Order
    {
        return $this->linkedOrder;
    }

    /**
     * @param Order|null $linkedOrder
     * @return $this
     */
    public function setLinkedOrder(?Order $linkedOrder): self
    {
        $this->linkedOrder = $linkedOrder;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTotal(): ?int
    {
        return $this->total;
    }

    /**
     * @param string $total
     * @return $this
     */
    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCost(): ?string
    {
        return $this->cost;
    }

    /**
     * @param int $cost
     * @return $this
     */
    public function setCost(int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }
}
