<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\MailContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, array(
            'required'=>true,
           
            'attr'=>array('class'=>'form-control','placeholder'=>' nom du contact')
            ))
        ->add('prenom', TextType::class, array(
            'required'=>true,
               
            'attr'=>array('class'=>'form-control','placeholder'=>' prenom du contact')
            ))
        ->add('email', EmailType::class, array(
                    
        'required'=>true,
                   
            'attr'=>array('class'=>'form-control','placeholder'=>' mail du contact')
             ))
        ->add('telephone', TextType::class, array(
            'required'=>true,
                       
            'attr'=>array('class'=>'form-control','placeholder'=>' numero du contact')
            ))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
