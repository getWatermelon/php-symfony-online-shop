<?php

namespace App\Controller;

use App\DTO\ContactRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class PageController
 * @package App\Controller
 */
class PageController extends AbstractController
{

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param DenormalizerInterface $denormalizer
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function contactUs(
        Request $request,
        ValidatorInterface $validator,
        DenormalizerInterface $denormalizer
//        $googleKey
    )
    {
        $errors = [];
        if ($request->isMethod('post') && $request->request->has('contact')) {
            $contact = $request->request->get('contact');
            $contactObj = $denormalizer->denormalize($contact, ContactRequest::class);
            $errors = $validator->validate($contactObj);
        }
        return $this->render('page/contact_us.html.twig', [
            'controller_name' => 'PageController',
            'errors' => $errors
//            'googleKey' => $googleKey
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function aboutUs()
    {
        return $this->render('page/about.html.twig');
    }
}