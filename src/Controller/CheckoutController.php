<?php

namespace App\Controller;

use App\Service\Cart\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{

    public function index(Cart $cart)
    {
        return $this->render('checkout/index.html.twig', [
            'cart' => $cart,
        ]);
    }

    public function pay()
    {

    }
}
