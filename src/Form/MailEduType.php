<?php

namespace App\Form;

use App\Entity\MailEdu;
use App\Entity\Educateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MailEduType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
        ->add('educateur', EntityType::class, [
            'class' => Educateur::class,
            'attr' => [
                'class' => 'form-control select2 js-select2', // Fusionnez les classes
                'placeholder' => 'A',
            ],
            
            'mapped' => false,
            'multiple' => true,
            'choice_label' => function ($educateur) {
                return $educateur->getNom() . ' - ' . $educateur->getPrenom() . ' - ' . $educateur->getEmail();
            },
        ])
        
            ->add('objet', TextType::class, array(
                'required'=>true,
               
                'attr'=>array('class'=>'form-control','placeholder'=>' objet')
                ))
                ->add('message', TextareaType::class, [
                    'attr' => [
                        'class' => 'form-control summernote',
                        'placeholder' => 'Saisissez votre message',
                        'rows' => 4,
                    ],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MailEdu::class,
        ]);
    }
}
