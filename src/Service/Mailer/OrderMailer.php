<?php
declare(strict_types=1);


namespace App\Service\Mailer;


use App\Entity\Order;
use App\Service\Cart\Cart;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

/**
 * Class OrderMailer
 * @package App\Service
 */
class OrderMailer
{
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * OrderMailer constructor.
     * @param MailerInterface $mailer
     * @param Cart $cart
     */
    public function __construct(MailerInterface $mailer, Cart $cart)
    {
        $this->mailer = $mailer;
        $this->cart = $cart;
    }

    /**
     * @param Order $order
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function mail(Order $order): void
    {
        $tempate = new TemplatedEmail();
        $tempate->from(new Address('no-reply@shop-symfony.com', 'Магазин'))
            ->to($order->getEmail())
            ->subject('Ваш заказ успешно получен')
            ->htmlTemplate('mail/order.html.twig')
            ->context([
                'cart' => $this->cart,
            ]);
        $this->mailer->send($tempate);
    }
}