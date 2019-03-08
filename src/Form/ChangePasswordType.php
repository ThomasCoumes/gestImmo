<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe actuel',
            ])

            ->add('newPassword', RepeatedType::class, [
                'type'            => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'options'         => [
                    'attr' => [
                        'class' => 'password-field',
                    ],
                ],
                'first_options'   => ['label' => 'Nouveau mot de passe ', 'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un mot de passe.',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre nouveau mot de passe ne doit pas faire moins de {{ limit }} caractères',
                        'max' => 180
                    ]),
                ],],
                'second_options'  => ['label' => 'Répéter nouveau mot de passe', 'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un mot de passe.',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre nouveau mot de passe ne doit pas faire moins de {{ limit }} caractères',
                        'max' => 180
                    ]),
                ],],
                'required' => true,
            ])

            ->add('changePassword', SubmitType::class, [
                'label' => 'Changer le mot de passe',
                'attr'  => [
                    'class' => 'btn btn-primary text-align-center',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
