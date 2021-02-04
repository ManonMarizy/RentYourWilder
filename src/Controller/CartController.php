<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/panier", name="cart_")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param CartService $cartService
     * @return Response|AccessDeniedHttpException
     */
    public function index(CartService $cartService)
    {
        $this->userVerification();
        return $this->render('cart/index.html.twig', [
            'wilders' => $cartService->getFullCart()
        ]);
    }

    /**
     * @Route("/ajout/{id}", name="add")
     * @param $id
     * @param CartService $cartService
     * @return RedirectResponse|AccessDeniedHttpException
     */
    public function add($id, CartService $cartService)
    {
        $this->userVerification();
        $cartService->add($id);
        $this->addFlash('success', 'Le wilder a été ajouté au panier !');
        return $this->redirectToRoute("home");
    }

    /**
     * @Route("/remove/{id}", name="remove")
     * @param $id
     * @param CartService $cartService
     * @return RedirectResponse|AccessDeniedHttpException
     */
    public function remove($id, CartService $cartService)
    {
        $this->userVerification();
        $cartService->remove($id);
        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/validation", name="validate")
     * @param CartService $cartService
     * @return RedirectResponse|AccessDeniedHttpException
     */
    public function valideCart(CartService $cartService)
    {
        $cartService->valideCart($cartService->getFullCart(), $this->userVerification()->getId());

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @return object|AccessDeniedHttpException|UserInterface
     */
    private function userVerification()
    {
        $user = $this->getUser();
        if(!$user) {
            return new AccessDeniedHttpException();
        }
        return $user;
    }
}