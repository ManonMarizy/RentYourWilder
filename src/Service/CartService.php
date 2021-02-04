<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Wilder;
use App\Repository\UserRepository;
use App\Repository\WilderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CartService
{
    protected SessionInterface $session;
    protected WilderRepository $wilderRepository;
    protected EntityManagerInterface $emi;
    protected UserRepository $userRepository;

    public function __construct(
        SessionInterface $session,
        WilderRepository $wilderRepository,
        EntityManagerInterface $emi,
        UserRepository $userRepository
    ) {
        $this->session = $session;
        $this->wilderRepository = $wilderRepository;
        $this->emi = $emi;
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $id
     */
    public function add(int $id)
    {
        $wilder = $this->wilderRepository->findOneBy([
            'id' => $id
        ]);

        if(!$wilder->getIsAvailable() || !$wilder->getIsEnable() || !$wilder) {
            throw new AccessDeniedHttpException();
        }

        $cart = $this->session->get('cart', []);
        if (!in_array($id, $cart)) {
            $cart[$id] = 1;
        } else {
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    /**
     * @param int $id
     */
    public function remove(int $id)
    {
        $cart = $this->session->get('cart', []);
        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $this->session->set('cart', $cart);

    }

    /**
     * @return array
     */
    public function getFullCart(): array
    {
        $cart = $this->session->get('cart', []);
        $cartWithData = [];
        foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'wilder' => $this->wilderRepository->findOneBy([
                    'id' => $id
                ]),
            ];
        }
        return $cartWithData;
    }

    /**
     * @param array $cartWithData
     * @param int $id
     */
    public function valideCart(array $cartWithData, int $id)
    {
        $user = $this->userRepository->findOneBy([
            'id' => $id
        ]);
        $cart = $this->session->get('cart', []);
        foreach ($cartWithData as $cartData) {
            /** @var Wilder $wilder */
            foreach ($cartData as $wilder) {
                $wilder->setIsAvailable(false);
                $wilder->setUser($user);
                $this->emi->flush();
                unset($cart[$wilder->getId()]);
            }
        }

        $this->session->set('cart', $cart);
    }
}