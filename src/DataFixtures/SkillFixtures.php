<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture
{
    const SKILLS = ['PHP', 'Symfony' ,'JS vanilla' ,'React' ,'Node.js'];

    public function load(ObjectManager $manager)
    {
        $i = 1;
       foreach (self::SKILLS as $skillName) {
           $skill = new Skill();
           $skill->setName($skillName);
           $manager->persist($skill);
           $this->addReference('skill_' . $i, $skill);
           $i++;
       }
        $manager->flush();
    }

}