<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('code', TextType::class, array(
            'required'=>true,
           
            'attr'=>array('class'=>'form-control','placeholder'=>' Code categorie')
            ))
            ->add('nom', TextType::class, array(
                'required'=>true,
               
                'attr'=>array('class'=>'form-control','placeholder'=>'libelle categorie')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
