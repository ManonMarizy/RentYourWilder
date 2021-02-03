<?php

namespace App\Controller;

use App\Entity\Wilder;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param CartService $cartService
     * @return Response
     */
    public function index(CartService $cartService): Response
    {
        $wilders = $this->getDoctrine()
            ->getRepository(Wilder::class)
            ->findBy([
                'isEnable' => true
            ]);

        return $this->render('home/index.html.twig', [
            'wilders' => $wilders,
            'cartWithData' => array_column($cartService->getFullCart(), 'wilder'),
        ]);
    }

    public function addNavBar(CartService $cartService): Response
    {
        return $this->render('includes/_navBar.html.twig', [
            'cartWithData' => $cartService->getFullCart(),
        ]);
    }
}