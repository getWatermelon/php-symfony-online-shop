<?php

namespace App\Entity;

use App\Repository\PriceRepository;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{

    const DEFAULT_RATING = 3;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mainImage;

    /**
     * @ORM\OneToMany(targetEntity=Price::class, mappedBy="product", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="product", orphanRemoval=true)
     */
    private $rating;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="products")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=OrderProduct::class, mappedBy="product")
     */
    private $orderProducts;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="product")
     */
    private $comments;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $images = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $isOnSale;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isTop;


    public function __construct()
    {
        $this->price = new ArrayCollection();
        $this->rating = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->orderProducts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->mainImage = 'standart_product_image.jpg';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMainImage(): ?string
    {
        return $this->mainImage;
    }

    public function setMainImage(?string $mainImage): self
    {
        $this->mainImage = $mainImage;

        return $this;
    }


    public function getPrice()
    {
        return $this->price;
    }


    public function addPrice(Price $price): self
    {
        if (!$this->price->contains($price)) {
            $this->price[] = $price;
            $price->setProduct($this);
        }

        return $this;
    }

    public function removePrice(Price $price): self
    {
        if ($this->price->contains($price)) {
            $this->price->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getProduct() === $this) {
                $price->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRating(): Collection
    {
        return $this->rating;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->rating->contains($rating)) {
            $this->rating[] = $rating;
            $rating->setProduct($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->rating->contains($rating)) {
            $this->rating->removeElement($rating);
            // set the owning side to null (unless already changed)
            if ($rating->getProduct() === $this) {
                $rating->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addProduct($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->removeProduct($this);
        }

        return $this;
    }


    public function getCurrentPrice() : float
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('isCurrent', true));

        /** @var Price $currPrice */
        $currPrice = $this->price->matching($criteria)->current();
        return $currPrice->getValue();
    }

    public function getCurrentSalePrice() : float
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('isSale', true));

        /** @var Price $currPrice */
        $currPrice = $this->price->matching($criteria)->current();
        return $currPrice->getValue();
    }


    public function getCurrentRating() : int
    {
        $total = $this->rating->count();
        $sum = 0;
        if(empty($total)) {
            $total = Product::DEFAULT_RATING;
        }
        /** @var Rating $rating */
        foreach ($this->rating as $rating) {
            $sum += $rating->getValue();
        }
        return ceil($sum / $total);
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrder(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts[] = $orderProduct;
            $orderProduct->addProduct($orderProduct);
        }

        return $this;
    }


    public function removeOrder(Order $order): self
    {
        if ($this->orderProducts->contains($order)) {
            $this->orderProducts->removeElement($order);
            $order->removeProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setProduct($this);
        }

        return $this;
    }


    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getProduct() === $this) {
                $comment->setProduct(null);
            }
        }

        return $this;
    }


    public function getTopComments(): Collection
    {
        $criteria = Criteria::create()->where(new Comparison('replyTo', Comparison::IS, null));

        return $this->comments->matching($criteria);
    }


    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): self
    {
       $this->images = $images;

       return $this;
    }

    public function getIsOnSale(): ?bool
    {
        return $this->isOnSale;
    }

    public function setIsOnSale(bool $isOnSale): self
    {
        $this->isOnSale = $isOnSale;

        return $this;
    }

    public function getIsTop(): ?bool
    {
        return $this->isTop;
    }

    public function setIsTop(bool $isTop): self
    {
        $this->isTop = $isTop;

        return $this;
    }


}