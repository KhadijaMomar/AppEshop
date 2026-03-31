<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

    $builder
    ->add('firstName')
    ->add('name')
    ->add('phone', null, [
        'label' => 'Téléphone',
        'attr' => [
        'pattern' => '[0-9]*',
        'inputmode' => 'numeric',
        'placeholder' => 'Ex: 0612345678'
        ],
        'constraints' => [
            new Assert\NotBlank(message: 'Veuillez saisir votre numéro de téléphone.'),
            new Assert\Regex(
                pattern: '/^[0-9]+$/',
                message: 'Le numéro de téléphone doit contenir uniquement des chiffres.'
            ),
            new Assert\Length(
                min: 10,
                max: 15,
                minMessage: 'Le numéro doit contenir au moins {{ limit }} caractères.',
                maxMessage: 'Le numéro doit contenir au maximum {{ limit }} caractères.'
            )
        ]
    ])
    ->add('email', EmailType::class, [
    'constraints' => [
        new Assert\NotBlank(message: 'Veuillez entrer un email.'),
        new Assert\Email(message: 'Email invalide.')
    ]
    ])
    ->add('birthDate', DateType::class, [
        'widget' => 'single_text',
        'constraints' => [
            new Assert\NotBlank(message: 'Veuillez entrer votre date de naissance.'),
            new Assert\LessThan(
                value: new \DateTime('-18 years'),
                message: 'Vous devez avoir au moins 18 ans pour vous inscrire.'
            )
        ]
    ])
    ->add('plainPassword', RepeatedType::class, [
        'type' => PasswordType::class,
        'mapped' => false,
        'first_options'  => ['label' => 'Mot de passe'],
        'second_options' => ['label' => 'Confirmer le mot de passe'],
        'constraints' => [
            new Assert\NotBlank(message: 'Veuillez saisir un mot de passe.'),
            new Assert\Length(
                min: 6,
                minMessage: 'Votre mot de passe doit contenir au moins {{ limit }} caractères.'
            )
        ]
    ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
