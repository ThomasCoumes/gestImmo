<?php

namespace App\Form;

use App\Entity\Lessee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class LesseeType
 * @package App\Form
 */
class LesseeType extends AbstractTypedgfdfgdfgdf
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility', ChoiceType::class, [
                'label' => 'Civilite',
                'choices' => [
                    'Mr' => 'Mr',
                    'Mme' => 'Mme',
                    'Mlle' => 'Mlle',
                ]
            ])
            ->add('name', TextType::class, ['label' => 'Prénom'])
            ->add('lastname', TextType::class, ['label' => 'Nom'])
            ->add('birthday', BirthdayType::class, ['label' => 'Date de naissance'])
            ->add('placeOfBirth', TextType::class, ['label' => 'Lieu de naissance'])
            ->add('email', EmailType::class, ['label' => 'Adresse email'])
            ->add('phoneNumber', TelType::class, ['label' => 'Numéro de telephone'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lessee::class,
        ]);
    }
}
