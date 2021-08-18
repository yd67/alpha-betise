<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom' ,TextType::class,[  
            'required' => true,
            'label' => 'nom',
            'constraints' => [
                new Length([
                    'min' => 2,
                    'minMessage' => 'Votre nom doit comporter au minimun  {{ limit }} characters',
                    'max' => 30,
                    'maxMessage' => 'Votre  doit comporter au minimun  {{ limit }} characters',

                ]),
            ]
            ])
        ->add('prenom',TextType::class,[
            'required' => true,
            'label' => 'prenom',
            'constraints' => [
                new Length([
                    'min' => 2,
                    'minMessage' => 'Votre prenom doit comporter au minimun  {{ limit }} characters',
                    'max' => 30,
                    'maxMessage' => 'Votre prenom doit comporter au minimun  {{ limit }} characters',

                ]),
            ]
        ])
        ->add('email',EmailType::class,[
            'required' => true,
            'label' =>'email'
        ])
        ->add('message',TextareaType::class,[
            'required' => true,
            'label' => 'message',
            'attr' => [
                'minlength' => 5,
                'maxlength' => 1000
            ],
            'help' => '5 characteres min et 1000 caractères maximum  '
        ])
       
      
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
