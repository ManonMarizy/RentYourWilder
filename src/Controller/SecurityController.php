<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\ForgottenPasswordType;
use App\Form\ResetPasswordType;
use App\Service\GenerateTokenService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser() !== null) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $errorMessage = $error !== null ? $error->getMessage() : '';
        if ($error instanceof BadCredentialsException) {
            $errorMessage = 'Email ou mot de passe incorrect';
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'errorMessage' => $errorMessage,
            'csrf_token_intention' => 'authenticate',
        ]);
    }

    /**
     * @Route("/login-check", name="login_check")
     */
    public function loginCheck(): void
    {
    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/mot-de-passe-oublie", methods={"GET", "POST"}, name="mail_reset_password")
     * @param Request $request
     * @param string $mailerFromAddress
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function mailResetPassword(Request $request, string $mailerFromAddress, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ForgottenPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData();
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findOneBy(['email' => $email]);
            if ($user === null) {
                $this->addFlash('success', 'Votre email est inconnu');
                return $this->redirectToRoute("mail_reset_password");
            }
            $user->setToken(GenerateTokenService::generateToken());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $email = (new Email())
                ->from($mailerFromAddress)
                ->to($email['email'])
                ->subject('Réinitialisation du mot de passe pour Loue ton Wilder')
                ->html($this->renderView('mail/reset_password_mail.html.twig', [
                    'user' => $user
                ]));
            $mailer->send($email);
            $this->addFlash('success', 'Un email vient de vous être envoyé !');
            return $this->redirectToRoute("mail_reset_password");
        }
        return $this->render('security/forgotten_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/mot-de-passe-oublie/{token}", methods={"GET", "POST"}, name="reset_password")
     * @ParamConverter("user", class="App\Entity\User", options={"mapping": {"token": "token"}})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param User $user
     * @return Response
     */
    public function resetPassword(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        User $user
    ): Response {
        if ($this->getUser() !== null) {
            return $this->redirectToRoute('home');
        }
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->getData();
            $encoded = $encoder->encodePassword($user, $password->getPassword());
            $user->setPassword($encoded);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute("app_login");
        }

        return $this->render('security/reset_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
