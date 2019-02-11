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
            ->add('propertyType')
            ->add('uniqueName')
            ->add('address')
            ->add('city')
            ->add('zipCode')
            ->add('country')
            ->add('surfaceInSquarMeter')
            ->add('numberOfPiece')
            ->add('description')
            ->add('equipment')
            ->add('rentalType')
            ->add('rentExcludingCharge')
            ->add('charges')
            ->add('purchasePrice')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
