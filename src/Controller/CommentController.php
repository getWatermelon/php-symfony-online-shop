<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Product;
use App\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class CommentController
 * @package App\Controller
 */
class CommentController extends AbstractController
{


    /**
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function newComment(Request $request, Product $product): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setProduct($product);

            $comment->setUser($this->getUser());

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return $this->render('comment/new.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @ParamConverter("comment", options={"id" = "commentId"})
     */
    public function addCommentReply(Request $request, Product $product, Comment $comment): Response
    {
        $submittedToken = $request->request->get('token');

        // 'delete-item' is the same value used in the template to generate the token
        if (!$this->isCsrfTokenValid('comment-token', $submittedToken)) {
            throw new BadRequestException('Bad CSRF token from comment received');
        }
        $reply = new Comment();
        $entityManager = $this->getDoctrine()->getManager();
        $reply->setProduct($product);
        $reply->setUser($this->getUser());
        $reply->setReplyTo($comment);
        $body = $request->request->get('body');
        $reply->setBody($body);
        $entityManager->persist($reply);
        $entityManager->flush();


        return $this->redirectToRoute('product_show', ['id' => $product->getId()]);

    }

}
