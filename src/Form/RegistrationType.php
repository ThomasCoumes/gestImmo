<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'Adresse email', 'attr' => [
                'placeholder' => 'Votre adresse email'
            ]])
            ->add('password', PasswordType::class, ['label' => 'Mot de passe', 'attr' => [
                'placeholder' => 'Votre mot de passe'
            ]])
            ->add('confirm_password', PasswordType::class, ['label' => 'Confirmer le mot de passe', 'attr' => [
                'placeholder' => 'Répétez votre mot de passe'
            ]])
            ->add('name', TextType::class, ['label' => 'Prénom', 'attr' => [
                'placeholder' => 'Votre prénom'
            ]])
            ->add('lastName', TextType::class, ['label' => 'Nom', 'attr' => [
                'placeholder' => 'Votre nom'
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
