<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Recette;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'attr' => [
                'class' => 'form-control mb-3',  
                'placeholder' => 'Entrez le nom de la recette',
            ],
            'label' => "Nom de la recette :",
            'label_attr' => [
                'class' => 'form-label',  
            ]
        ])

     
       
       
        ->add('slug', TextType::class, [
            'attr' => [
                'class' => 'form-control mb-3', 
            ],
            'label' => "Slug de la recette :",
            'label_attr' => [
                'class' => 'form-label',  
            ]
        ])
        


     
       
   
        ->add('categorie', EntityType::class, [
            'class' => Categorie::class,
            'attr' => [
                'class' => 'form-control ',
            ],
            'label' => "Votre catégorie :",
            'label_attr' => [
                'class' => 'form-label',  
            ]
        ])
        

        
        
      ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }
}