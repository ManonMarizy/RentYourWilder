<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\WilderHasSkill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'label' => 'Langage',
            ])
            ->add('rate', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 5
                ],
                'invalid_message' => 'La note va de 0 à 5',
                'label' => 'Note',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WilderHasSkill::class,
        ]);
    }
}