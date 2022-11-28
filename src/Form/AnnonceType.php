<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use \Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price')
            ->add('sold')
            ->add('status', ChoiceType::class,[
                "choices" => [
                    "Très mauvais" => Annonce::STATUS_VERY_BAD,
                    "Mauvais" => Annonce::STATUS_BAD,
                    "Bon" => Annonce::STATUS_GOOD,
                    "Très bon" => Annonce::STATUS_VERY_GOOD,
                    "Parfait" => Annonce::STATUS_PERFECT,
                ]
            ])
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('slug')
            ->add('imageUrl')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
