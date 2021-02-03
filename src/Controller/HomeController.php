<?php

namespace App\Controller;

use App\Entity\Wilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $wilders = $this->getDoctrine()
            ->getRepository(Wilder::class)
            ->findBy([
                'isEnable' => true
            ]);

        return $this->render('home/index.html.twig', [
            'wilders' => $wilders
        ]);
    }
}