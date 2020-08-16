<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Form\OrderType;
use App\Service\Cart\Cart;
use App\Service\Cart\Item;
use App\Service\Mailer\OrderMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{

    public function index(Cart $cart, Request $request, EntityManagerInterface $em, OrderMailer $mailer)
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($cart->isEmpty()) {
                throw new BadRequestException('You are not allowed to do this action');
            }
            $order->setStatus(0);
            /** @var Item $item */
            foreach ($cart->getItems() as $item) {
//                $order->addProduct($item->getProduct());
//                $em->persist($item->getProduct());
                $orderProduct = new OrderProduct();
                $orderProduct->setLinkedOrder($order);
                $orderProduct->setProduct($item->getProduct());
                $orderProduct->setCost($item->getCost());
                $orderProduct->setTotal($item->getCount());
                $em->persist($orderProduct);
            }
            $em->persist($order);
            $em->flush();
            $mailer->mail($order);
            $cart->clear();
            return $this->redirectToRoute('checkout', ['status' => 1]);
        }
        return $this->render('checkout/index.html.twig', [
            'cart' => $cart,
            'form' => $form->createView()
        ]);
    }

    public function pay()
    {

    }
}
