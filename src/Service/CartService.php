<?php

namespace App\Service;

use App\Repository\WilderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CartService
{
    protected SessionInterface $session;
    protected WilderRepository $wilderRepository;
    protected EntityManagerInterface $emi;

    public function __construct(SessionInterface $session, WilderRepository $wilderRepository, EntityManagerInterface $emi)
    {
        $this->session = $session;
        $this->wilderRepository = $wilderRepository;
        $this->emi = $emi;
    }

    /**
     * @param int $id
     */
    public function add(int $id)
    {
        $wilder = $this->wilderRepository->findOneBy([
            'id' => $id
        ]);

        if(!$wilder->getIsAvailable() || !$wilder->getIsEnable()) {
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
     * @param $cartWithData
     */
    public function valideCart($cartWithData)
    {
        $cart = $this->session->get('cart', []);
        foreach ($cartWithData as $cartData) {
            foreach ($cartData as $wilder) {
                $wilder->setIsAvailable(false);
                $this->emi->flush();
                unset($cart[$wilder->getId()]);
            }
        }

        $this->session->set('cart', $cart);
    }
}