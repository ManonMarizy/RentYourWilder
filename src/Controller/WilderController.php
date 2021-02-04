<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Wilder;
use App\Form\WilderType;
use App\Repository\WilderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/wilder")
 */
class WilderController extends AbstractController
{
    /**
     * @Route("/", name="wilder_index", methods={"GET"})
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
     * @Route("/new", name="wilder_new", methods={"GET","POST"})
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
     * @Route("/{id}", name="wilder_show", methods={"GET"})
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
     * @Route("/{id}/edit", name="wilder_edit", methods={"GET","POST"})
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
     * @Route("/{id}", name="wilder_delete", methods={"DELETE"})
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
     * @Route("/stop-renting/wilder/{id}", name="strop_renting", methods={"GET"})
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
}
