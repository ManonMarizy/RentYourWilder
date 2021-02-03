<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationType;
use App\Service\GenerateTokenService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/utilisateur", name="user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/inscription", methods={"GET", "POST"}, name="register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param string $mailerFromAddress
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        string $mailerFromAddress,
        MailerInterface $mailer
    ): Response {
        if ($this->getUser() !== null) {
            return $this->redirectToRoute('home');
        }
        $form = $this->createForm(UserRegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $userExist = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy([
                    'email' => $user->getEmail()
                ]);
            if ($userExist !== null) {
                $this->addFlash('error', 'Cette adresse mail est déjà utilsée');
                return $this->redirectToRoute('user_register');
            }
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $user->setToken(GenerateTokenService::generateToken());
            $user->setIsActivate(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $email = (new Email())
                ->from($mailerFromAddress)
                ->to($user->getEmail())
                ->subject('Inscription pour Loue ton Wilder')
                ->html($this->renderView('mail/register_mail.html.twig', [
                    'user' => $user
                ]));
            $mailer->send($email);
            $this->addFlash(
                'success',
                'Un email pour valider votre inscription vient de vous être envoyé !'
            );
            return $this->redirectToRoute("app_login");
        }
        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/inscription/validation/{token}", methods={"GET"}, name="register_validation")
     * @ParamConverter("user", class="App\Entity\User", options={"mapping": {"token": "token"}})
     * @param User $user
     * @return Response
     */
    public function activateAccount(User $user): Response
    {
        if ($this->getUser() !== null) {
            return $this->redirectToRoute('home');
        }
        $user->setIsActivate(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->render('user/register_validation.html.twig', [
            'user' => $user
        ]);
    }
}