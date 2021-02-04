<?php

namespace App\DataFixtures;

use App\Entity\Wilder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WilderFixtures extends  Fixture
{
    const WILDERS = [
        1 => [
            'name' => 'Guillem',
            'description' => 'Descriptif : de bons moments passés (call 911) en peer programming avec Amandine (help c\'était pas une syncope) ! Vous allez me manquer !',
            'avatar' => 'Guillem DARDILL avatar.jpg',
        ],
        2 => [
            'name' => 'Yoann',
            'description' => 'Après 6 ans en tant que chargé d\'études naturalistes, spécialisé dans les Lépidoptères, les Odonates et les Arachnides, c\'est tout logiquement que je me suis orienté vers le Développement web !
                ...
                En tout cas ça me semble logique...
                Vive les concours de chaussettes !',
            'avatar' => 'indi.png',
        ],
        3 => [
            'name' => 'Florian',
            'description' => 'Amateur chevronné de VR, passe son temps à tuer des personnes virtuelles à defaut de pouvoir le faire en vrai',
            'avatar' => 'waffle.png',
        ],
        4 => [
            'name' => 'Sabrina',
            'description' => 'Encore en apprentissage, je ne désespère pas !',
            'avatar' => 'Sabrina.jpg',
        ],
        5 => [
            'name' => 'Maxime',
            'description' => 'Fier développeur de la tribu PHP/Symfony, il ne manquera pas de donner de sa personne pour subvenir à vos moindres desiderata, en PHP car JS c’est quand même un language bizarre... Une valeure sûre !',
            'avatar' => 'otter.jpg',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::WILDERS as $key => $data) {
            $wilder = new Wilder();
            $wilder->setName($data['name']);
            $wilder->setDescription($data['description']);
            $wilder->setAvatar($data['avatar']);
            $wilder->setUpdatedAt(new \DateTime());
            $wilder->setIsAvailable(true);
            $wilder->setIsEnable(true);
            $manager->persist($wilder);
            $this->addReference('wilder_' . $key, $wilder);
        }
        $manager->flush();
    }

}
