<?php

namespace App\Form;

use App\Entity\Educateur;
use App\Entity\MailEdu;
use App\Entity\Categorie;
use App\Entity\Contact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EducateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('numero', TextType::class, array(
            'required'=>true,
           
            'attr'=>array('class'=>'form-control','placeholder'=>' Identifiant educateur')
            ))
            ->add('nom', TextType::class, array(
                'required'=>true,
               
                'attr'=>array('class'=>'form-control','placeholder'=>' nom du educateur')
                ))
                ->add('prenom', TextType::class, array(
                    'required'=>true,
                   
                    'attr'=>array('class'=>'form-control','placeholder'=>' prenoms  educateur')
                ))
            ->add('categorie', EntityType::class, [
                'class' => categorie::class,
                'attr'=>array('class'=>'form-control','placeholder'=>' categorie educateur'),
                'choice_label' => function ($categorie) {
                    return $categorie->getCode() . ' - ' . $categorie->getNom() ;
                },
            ])
            ->add('contact', EntityType::class, [
                'class' => contact::class,
                'attr' => [
                    'class' => 'form-control select2 ', 
                    'placeholder' => 'Contact du educateur',
                ],

                'attr' => ['class' => 'js-select2'],

                'choice_label' => function ($contact) {
                    return $contact->getNom() . ' - ' . $contact->getPrenom() . ' - ' . $contact->getTelephone();
                },
            ])
            ->add('email', EmailType::class, array(
                    
                'required'=>true,
                           
                    'attr'=>array('class'=>'form-control','placeholder'=>' mail educateur')
                     ))
            ->add('pwd', PasswordType::class, array(
                        'required'=>true,
                        
                        'attr'=>array('class'=>'form-control','placeholder'=>'votre mot de passe (minimum 6 caractères)')
                    ))
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Educateur::class,
        ]);
    }
}
