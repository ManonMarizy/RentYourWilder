<?php

namespace App\DataFixtures;

use App\Entity\WilderHasSkill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class WilderHasSkillFixtures extends Fixture implements DependentFixtureInterface
{

    const RATESPERWILDER = [
        1 => [
            1 => [
                'skill' => 1,
                'rate' => 0
            ],
            2 => [
                'skill' => 2,
                'rate' => 0
            ],
            3 => [
                'skill' => 3,
                'rate' => 3
            ],
            4 => [
                'skill' => 4,
                'rate' => 5
            ],
            5 => [
                'skill' => 5,
                'rate' => 4
            ],
        ],
        2 => [
            1 => [
                'skill' => 1,
                'rate' => 4
            ],
            2 => [
                'skill' => 2,
                'rate' => 4
            ],
            3 => [
                'skill' => 3,
                'rate' => 2
            ],
            4 => [
                'skill' => 4,
                'rate' => 0
            ],
            5 => [
                'skill' => 5,
                'rate' => 0
            ],
        ],
        3 => [
            1 => [
                'skill' => 1,
                'rate' => 4
            ],
            2 => [
                'skill' => 2,
                'rate' => 2
            ],
            3 => [
                'skill' => 3,
                'rate' => 3
            ],
            4 => [
                'skill' => 4,
                'rate' => 2
            ],
            5 => [
                'skill' => 5,
                'rate' => 1
            ],
        ],
        4 => [
            1 => [
                'skill' => 1,
                'rate' => 0
            ],
            2 => [
                'skill' => 2,
                'rate' => 0
            ],
            3 => [
                'skill' => 3,
                'rate' => 2
            ],
            4 => [
                'skill' => 4,
                'rate' => 2
            ],
            5 => [
                'skill' => 5,
                'rate' => 1
            ],
        ],
        5 => [
            1 => [
                'skill' => 1,
                'rate' => 4
            ],
            2 => [
                'skill' => 2,
                'rate' => 4
            ],
            3 => [
                'skill' => 3,
                'rate' => 2
            ],
            4 => [
                'skill' => 4,
                'rate' => 1
            ],
            5 => [
                'skill' => 5,
                'rate' => 1
            ],
        ],
    ];


    public function load(ObjectManager $manager)
    {
        foreach (self::RATESPERWILDER as $key => $data) {
            foreach ($data as $skill) {
                $wilderHasSkill = new WilderHasSkill();
                $wilderHasSkill->setWilders($this->getReference('wilder_' . $key));
                $wilderHasSkill->setSkills($this->getReference('skill_' . $skill['skill']));
                $wilderHasSkill->setRate($skill['rate']);
                $manager->persist($wilderHasSkill);
            }


        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [WilderFixtures::class, SkillFixtures::class];
    }
}