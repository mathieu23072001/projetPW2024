<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\MailContact;
use App\Form\MailContactType;
use App\Repository\LicencieRepository;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MailContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/mail/contact')]
class MailContactController extends AbstractController
{
    #[Route('/', name: 'app_mail_contact_index', methods: ['GET'])]
    public function index(MailContactRepository $mailContactRepository): Response
    {
        return $this->render('mail_contact/index.html.twig', [
            'mail_contacts' => $mailContactRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mail_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,MailerInterface $mailer, LicencieRepository $licencieRepository): Response
    {
        $mailContact = new MailContact();
        $form = $this->createForm(MailContactType::class, $mailContact);
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {
            $contacts = $form->get('contact')->getData();
            $categories = $form->get('categorie')->getData();

              if($contacts){
            foreach ($contacts as $contact) {
                $email = (new Email())
                    ->from($this->getUser()->getEmail()) 
                    ->to($contact->getEmail())
                    ->subject($form->get('objet')->getData())
                    ->text($form->get('message')->getData())
                    ->html('<p>See Twig integration for better HTML integration!</p>');
    
                $mailer->send($email);
    
                // Ajoutez l'éducateur au mail avant de le persister
                $mailContact->addContact($contact);
            }
        }

        if ($categories){

            foreach ($categories as $categorie) {

                $licencies = $licencieRepository->findBy(['categorie' => $categorie]);
                $contacts = [];
    
                foreach ($licencies as $licencie) {
                    $contact = $licencie->getContact();
            
                    
                    if ($contact && !in_array($contact, $contacts, true)) {
                        $contacts[] = $contact;
                    }
                }
    
             }

             foreach ($contacts as $contact) {
                $email = (new Email())
                    ->from($this->getUser()->getEmail()) 
                    ->to($contact->getEmail())
                    ->subject($form->get('objet')->getData())
                    ->text($form->get('message')->getData())
                    ->html('<p>See Twig integration for better HTML integration!</p>');
    
                $mailer->send($email);
    
                // Ajoutez l'éducateur au mail avant de le persister
                $mailContact->addContact($contact);
            }
        }

        if ($contacts && $categories) {
            $contactsFromCategories = [];
        
            foreach ($categories as $categorie) {
                $licencies = $licencieRepository->findBy(['categorie' => $categorie]);
        
                foreach ($licencies as $licencie) {
                    $contact = $licencie->getContact();
        
                    if ($contact && !in_array($contact, $contactsFromCategories, true)) {
                        $contactsFromCategories[] = $contact;
                    }
                }
            }
        
            // Fusionner les contacts des deux sources en éliminant les doublons
            $contacts = array_merge($contacts, $contactsFromCategories);
            $contacts = array_unique($contacts, SORT_REGULAR);
        
            foreach ($contacts as $contact) {
                $email = (new Email())
                    ->from($this->getUser()->getEmail())
                    ->to($contact->getEmail())
                    ->subject($form->get('objet')->getData())
                    ->text($form->get('message')->getData())
                    ->html('<p>See Twig integration for better HTML integration!</p>');
        
                $mailer->send($email);
        
                // Ajoutez l'éducateur au mail avant de le persister
                $mailContact->addContact($contact);
            }
        }
        
            
    
            // Enregistrez le mail dans la base de données
            $mailContact->setDateEnvoi(new \DateTime());
            $entityManager->persist($mailContact);
            $entityManager->flush();
    
            $this->addFlash('success', 'Les e-mails ont été envoyés avec succès.');
    
            return $this->redirectToRoute('app_mail_contact_index', [], Response::HTTP_SEE_OTHER);
        }
    

        return $this->render('mail_contact/new.html.twig', [
            'mail_contact' => $mailContact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mail_contact_show', methods: ['GET'])]
    public function show(MailContact $mailContact): Response
    {
        return $this->render('mail_contact/show.html.twig', [
            'mail_contact' => $mailContact,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mail_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MailContact $mailContact, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MailContactType::class, $mailContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mail_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mail_contact/edit.html.twig', [
            'mail_contact' => $mailContact,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_mail_contact_delete', methods: ['GET','POST'])]
    public function delete( $id, EntityManagerInterface $entityManager): Response
    {

        $mail_contact = $entityManager->getRepository(MailContact::class);
        $mail_contact = $mail_contact->find($id);
        
    
            $entityManager->remove($mail_contact);
            $entityManager->flush();
        

        
        $this->addFlash('delete', 'suppression effectué');
        return $this->redirectToRoute('app_mail_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
