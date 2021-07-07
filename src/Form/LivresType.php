<?php

namespace App\Form;

use App\Entity\Livres;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LivresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('img',FileType::class,[ 
                'required' => true,
            ])
            ->add('titre',TextType::class,[

            ])
            ->add('auteur',TextType::class,[

            ])
            ->add('editeur',TextType::class,[

            ])
            ->add('code',TextType::class,[

                ])
            ->add('prix',MoneyType::class,[

            ])
            ->add('avis_libraire',TextareaType::class,[

                'attr'=>[
                    'novalidate-off' => 'novalidate'
                ]
            ])
            ->add('resume',TextareaType::class,[

            ])
            ->add('stock',IntegerType::class,[

            ])
            ->add('category',EntityType::class,[
                'class'=> Category::class,
                'choice_label'=> 'nom_category',
                'attr' => [
                    'class'=> 'select'
                ]

            ])
            ->add('ajouter',SubmitType::class)
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livres::class,
        ]);
    }
}
