<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('propertyCategory')
            ->add('uniqueName')
            ->add('address')
            ->add('city')
            ->add('zipCode')
            ->add('country')
            ->add('surfaceInSquareMeter')
            ->add('numberOfPiece')
            ->add('description')
            ->add('equipment')
            ->add('rentalCategory')
            ->add('rentExcludingCharges')
            ->add('charges')
            ->add('purchasePrice')
            ->add('userProperty')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
