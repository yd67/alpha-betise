<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom',TextType::class)
            ->add('prenom',TextType::class)
            ->add('email',EmailType::class)
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'mot de passe',
                    'attr' => [
                        'class' => 'input',
                        'placeholder' => 'votre mot de passe '
                    ]
                ],
                'second_options' => [
                    'label' => 'comfirmer  mot de passe',
                    'attr' => [
                        'class' => 'input',
                        'placeholder' => ' comfirmer mot de passe '
                    ]
                ],
                'mapped' => false,
                'label' => 'mot de passe',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe ',
                    ]),
                   
                    new PasswordStrength([
                        'minLength' => 8,
                        'tooShortMessage' => 'Le mot de passe doit contenir au moins 8 caractères',
                        'minStrength' => 4,
                        'message' => 'Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial'
                    ])
                ],
            ])
            ->add('age',BirthdayType::class,[
                'label' => 'date de naissance'
            ])
            ->add('newsletter',ChoiceType::class,[
                'choices'  => [
                    'oui' => 'oui',
                    'non' => 'non' ,
                ],
                'label' => 's\'incrire a la newsletter ?'
            ])
            ->add('img',FileType::class,[
                'required'=> false,
                'label' => 'photo de profil',
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'accepte les conditions d\'utilisation ',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'vous devez accepter les conditions general d\'utilisation.',
                    ]),
                ],
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
