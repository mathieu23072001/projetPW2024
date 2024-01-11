<?php

namespace App\Form;

use App\Entity\Licencie;
use App\Entity\Categorie;
use App\Entity\Contact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LicencieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('numero', TextType::class, array(
            'required'=>true,
           
            'attr'=>array('class'=>'form-control','placeholder'=>' Identifiant du licencié')
            ))
            ->add('nom', TextType::class, array(
                'required'=>true,
               
                'attr'=>array('class'=>'form-control','placeholder'=>' nom du licencié')
                ))
                ->add('prenom', TextType::class, array(
                    'required'=>true,
                   
                    'attr'=>array('class'=>'form-control','placeholder'=>' prenoms du licencié')
                ))
            ->add('categorie', EntityType::class, [
                'class' => categorie::class,
                'attr'=>array('class'=>'form-control','placeholder'=>' categorie du licencié'),
                'choice_label' => function ($categorie) {
                    return $categorie->getCode() . ' - ' . $categorie->getNom() ;
                },
            ])
            ->add('contact', EntityType::class, [
                'class' => contact::class,
                'attr' => [
                    'class' => 'form-control select2 ', 
                    'placeholder' => 'Contact du licencié',
                ],

                'attr' => ['class' => 'js-select2'],

                'choice_label' => function ($contact) {
                    return $contact->getNom() . ' - ' . $contact->getPrenom() . ' - ' . $contact->getTelephone();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Licencie::class,
        ]);
    }
}
