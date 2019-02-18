<?php

namespace App\Form;

use App\Entity\Lessee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LesseeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility')
            ->add('name')
            ->add('lastname')
            ->add('birthday')
            ->add('placeOfBirth')
            ->add('email')
            ->add('phoneNumber')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lessee::class,
        ]);
    }
}
