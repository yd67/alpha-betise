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
                'data_class' => null  ,
                'required' => false,
                'label'=> 'photo du livre',
                
            ])
            ->add('titre',TextType::class,[

            ])
            ->add('auteur',TextType::class,[

            ])
            ->add('editeur',TextType::class,[

            ])
            ->add('code',TextType::class,[
                'label'=> 'Code EAN / ISBN'
            ])
            ->add('prix',MoneyType::class,[

            ])
            ->add('avis_libraire',TextareaType::class,[

                'attr'=>[
                    'novalidate-off' => 'novalidate'
                ]
            ])
            ->add('resume',TextareaType::class,[
                'label' => 'resumer du livre'

            ])
            ->add('stock',IntegerType::class,[

            ])
            ->add('category',EntityType::class,[
                'class'=> Category::class,
                'choice_label'=> 'nom_category',
                'attr' => [
                    'class'=> 'select'
                ],
                'label'=>'categorie'
            ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livres::class,
        ]);
    }
}
