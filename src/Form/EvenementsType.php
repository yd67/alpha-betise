<?php

namespace App\Form;

use App\Entity\Evenements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EvenementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('img',FileType::class,[
                'label'=>'image'
            ])
            ->add('title',TextType::class,[
                'label'=> 'Nom de l\'evenement'
            ])
            ->add('start',DateTimeType::class,[
                'date_widget' => 'single_text',
                'label'=> 'Debut de l\'evenement'
                
            ])
            ->add('end',DateTimeType::class,[
                'date_widget' => 'single_text',
                'label'=> 'Fin de l\'evenement'
                
            ])
            ->add('lieux',TextType::class,[
                'required'   => false,
                'empty_data' => 'a la librairie' 
            ])
            ->add('reservation',ChoiceType::class,[
                'choices' => [
                    'sur reservation' => true,
                    'pas de reservation' => false,
                ],
            ])
            ->add('max_personne',IntegerType::class)
            ->add('prix',IntegerType::class)
            ->add('age_cible',TextType::class)
            ->add('description',TextareaType::class)
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenements::class,
        ]);
    }
}
