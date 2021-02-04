<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Wilder;
use App\Form\WilderType;
use App\Repository\WilderRepository;
use App\Service\CartService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

class WilderController extends AbstractController
{
    /**
     * @Route("/admin/wilder/", name="wilder_index", methods={"GET"})
     * @param WilderRepository $wilderRepository
     * @return Response
     */
    public function index(WilderRepository $wilderRepository): Response
    {
        return $this->render('wilder/index.html.twig', [
            'wilders' => $wilderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/wilder/new", name="wilder_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $wilder = new Wilder();
        $form = $this->createForm(WilderType::class, $wilder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wilder);
            $entityManager->flush();

            return $this->redirectToRoute('wilder_index');
        }

        return $this->render('wilder/new.html.twig', [
            'wilder' => $wilder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/wilder/{id}", name="wilder_show", methods={"GET"})
     * @param Wilder $wilder
     * @return Response
     */
    public function show(Wilder $wilder): Response
    {
        return $this->render('wilder/show.html.twig', [
            'wilder' => $wilder,
        ]);
    }

    /**
     * @Route("/admin/wilder/{id}/edit", name="wilder_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Wilder $wilder
     * @return Response
     */
    public function edit(Request $request, Wilder $wilder): Response
    {
        $form = $this->createForm(WilderType::class, $wilder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wilder_index');
        }

        return $this->render('wilder/edit.html.twig', [
            'wilder' => $wilder,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/wilder/{id}", name="wilder_delete", methods={"DELETE"})
     * @param Request $request
     * @param Wilder $wilder
     * @return Response
     */
    public function delete(Request $request, Wilder $wilder): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wilder->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wilder);
            $entityManager->flush();
        }

        return $this->redirectToRoute('wilder_index');
    }

    /**
     * @Route("/wilder/stop-renting/wilder/{id}", name="wilder_strop_renting", methods={"GET"})
     * @param int $id
     * @param WilderRepository $wilderRepository
     * @return RedirectResponse|AccessDeniedHttpException
     */
    public function stopRenting(int $id, WilderRepository $wilderRepository)
    {
        /** @var User $user */
        $user = $this->getUser();
        $wilder = $wilderRepository->findOneBy([
            'id' => $id
        ]);

        if (!$wilder || !$user || $wilder->getUser()->getId() !== $user->getId()) {
            return new AccessDeniedHttpException();
        }
        $wilder->setIsAvailable(true);
        $wilder->setUser(null);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('user_account');
    }

    /**
     * @Route("/wilder/{wilderName}", name="wilder_details", methods={"GET"})
     * @ParamConverter("wilder", class="App\Entity\Wilder", options={"mapping": {"wilderName": "name"}})
     * @param Wilder $wilder
     * @param CartService $cartService
     * @return Response
     */
    public function details(Wilder $wilder, CartService $cartService): Response
    {
        return $this->render('wilder/details.html.twig', [
            'wilder' => $wilder,
            'cartWithData' => array_column($cartService->getFullCart(), 'wilder'),
        ]);
    }
}
