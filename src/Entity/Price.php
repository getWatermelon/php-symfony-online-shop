<?php

namespace App\Entity;

use App\Repository\PriceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PriceRepository::class)
 */
class Price
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="price")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="boolean", options={"default": "0"})
     */
    private $isCurrent;

    /**
     * @ORM\Column(type="boolean", options={"default": "0"})
     */
    private $isSale;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     *
     */
    public function __constract()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string|null $value
     * @return $this
     */
    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
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
     * @return bool|null
     */
    public function getIsCurrent(): ?bool
    {
        return $this->isCurrent;
    }

    /**
     * @param bool|null $isCurrent
     * @return $this
     */
    public function setIsCurrent(?bool $isCurrent): self
    {
        $this->isCurrent = $isCurrent;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsSale(): ?bool
    {
        return $this->isSale;
    }

    /**
     * @param bool $isSale
     * @return $this
     */
    public function setIsSale(bool $isSale): self
    {
        $this->isSale = $isSale;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
