<?php

namespace App\Form;

use App\Entity\FormContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom', TextType::class, [
                'attr' => ['placeholder' => "Votre Nom"],
                'label' => 'Nom',
            ])

            ->add('Prenom', TextType::class, [
                'attr' => ['placeholder' => "Votre Prenom"],
                'label' => 'Prenom',
            ])
            ->add('Email', TextType::class, [
                'attr' => ['class' => EmailType::class],
                'attr' => [
                    'placeholder' => "Votre Message"
                ],
                'label' => 'Email',
            ])
            // ->add('Telephone', NumberType::class, [
            //     'label' => 'Telephone',
            // ])
            ->add('Message', TextareaType::class, [
                'attr' => [
                    'placeholder' => "Votre Message"
                ],
                'label' => 'Message ',
            ]);
        // ->add('Envoyer', SubmitType::class, [
        //     'attr' => ['class' => 'btn btn-primary']
        // ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FormContact::class,
        ]);
    }
}
