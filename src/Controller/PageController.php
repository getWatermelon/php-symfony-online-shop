<?php

namespace App\Controller;

use App\DTO\ContactRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PageController extends AbstractController
{

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

    public function aboutUs()
    {
        return $this->render('page/about.html.twig');
    }
}