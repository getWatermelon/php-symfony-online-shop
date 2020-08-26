<?php
declare(strict_types=1);


namespace App\Service\Cart;


use App\Entity\Product;

/**
 * Class Item
 * @package App\Service\Cart
 */
class Item
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var int
     */
    private $count;

    /**
     * Item constructor.
     * @param Product $product
     * @param int $count
     */
    public function __construct(Product $product, int $count)
    {
        $this->product = $product;
        $this->count = $count;
    }

    /**
     * @return string|null
     */
    public function getTitle()
    {
        return $this->product->getTitle();
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return float|int
     */
    public function getCost()
    {
        return $this->count * $this->product->getCurrentPrice();
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}