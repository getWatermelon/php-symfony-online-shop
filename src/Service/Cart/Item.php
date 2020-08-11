<?php
declare(strict_types=1);


namespace App\Service\Cart;


use App\Entity\Product;

class Item
{
    private $product;

    private $count;

    public function __construct(Product $product, int $count)
    {
        $this->product = $product;
        $this->count = $count;
    }

    public function getTitle()
    {
        return $this->product->getTitle();
    }

    public function getCount()
    {
        return $this->count;
    }

    public function getCost()
    {
        return $this->count * $this->product->getCurrentPrice();
    }

    public function getProduct()
    {
        return $this->product;
    }
}