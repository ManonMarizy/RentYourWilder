<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setEmail('admin@ltw.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'Paswword1!'
        ));
        $admin->setIsActivate('1');
        $admin->setToken('admin');
        $this->addReference('user_1', $admin);

        $manager->persist($admin);

        $user= new User();
        $user->setEmail('user@ltw.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'Password1!'
        ));
        $user->setIsActivate('1');
        $user->setToken('user');
        $this->addReference('user_2', $user);

        $manager->persist($user);

        $manager->flush();
    }
}