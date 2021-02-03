<?php

namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    /**
     * @param UserInterface $user
     */
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }

        if (!$user->getIsActivate()) {
            throw new CustomUserMessageAccountStatusException(
                'Votre compte n\'est pas activé, vérifiez votre boite mail'
            );
        }
    }

    /**
     * @param UserInterface $user
     */
    public function checkPostAuth(UserInterface $user): void
    {
    }
}