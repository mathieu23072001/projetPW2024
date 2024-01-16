<?php

namespace App\Controller;

use App\Entity\Educateur;
use App\Form\EducateurType;
use App\Repository\ContactRepository;
use App\Repository\LicencieRepository;
use App\Repository\CategorieRepository;
use App\Repository\EducateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Mime\Email;

#[Route('/admin/educateur')]
class EducateurController extends AbstractController
{
    #[Route('/', name: 'app_educateur_index', methods: ['GET'])]
    public function index(EducateurRepository $educateurRepository): Response
    {

        return $this->render('educateur/index.html.twig', [
            'educateurs' => $educateurRepository->findAll(),
        ]);
    }


    #[Route('/dashboard', name: 'app_educateur_dashboard', methods: ['GET'])]
    public function dashboard(LicencieRepository $licencieRepository,ContactRepository $contactRepository,CategorieRepository $categorieRepository,EducateurRepository $educateurRepository, EntityManagerInterface $entityManager): Response
    {

        
        $nbreEdu = $educateurRepository->nbEducateur();
        $nbreCat = $categorieRepository->nbCategorie();
        $nbreCont = $contactRepository->nbContact();
        $nbreLicen = $licencieRepository->nbLicencie();
        
        return $this->render('educateur/dashboard.html.twig', [
            'nbreEdu'=> $nbreEdu,
            'nbreCat'=> $nbreCat,
            'nbreCont'=>$nbreCont,
            'nbreLicen'=>$nbreLicen
            
        ]);
    }
 
    

    

    #[Route('/mailEdu', name: 'app_educateur_mail_edu', methods: ['GET'])]
    public function mailEdu(): Response
    {
        return $this->render('educateur/mailEdu.html.twig', [
        ]);
    }

    #[Route('/mailContact', name: 'app_educateur_mail_contact', methods: ['GET'])]
    public function mailContact(): Response
    {
        return $this->render('educateur/mailContact.html.twig', [
        ]);
    }



    #[Route('/new', name: 'app_educateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher): Response
    {
        $educateur = new Educateur();
        $form = $this->createForm(EducateurType::class, $educateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $generatedCode = 'EDU' . uniqid();
           $educateur->setNumero($generatedCode);
            $pwd= $form->get('pwd')->getData();

            $hashedPassword = $passwordHasher->hashPassword(
                $educateur,
                $pwd
            );

            //$isAdmin = $request->request->get('form')['isAdmin'];
            $isAdmin = $request->request->get('isAdmin');
            $educateur->setIsAdmin($isAdmin? 1 : 0);
            $educateur->setPassword($hashedPassword);
            $entityManager->persist($educateur);
            $entityManager->flush();
             
            $this->addFlash('success', 'enregistrement effectué');

            return $this->redirectToRoute('app_educateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('educateur/new.html.twig', [
            'educateur' => $educateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_educateur_show', methods: ['GET'])]
    public function show(Educateur $educateur): Response
    {
        return $this->render('educateur/show.html.twig', [
            'educateur' => $educateur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_educateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Educateur $educateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EducateurType::class, $educateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
 
            $this->addFlash('modify', 'modification effectué');
            return $this->redirectToRoute('app_educateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('educateur/new.html.twig', [
            'educateur' => $educateur,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_educateur_delete',  methods: ['GET', 'POST'])]
    public function delete( $id, EntityManagerInterface $entityManager): Response
    {

        $educateur = $entityManager->getRepository(Educateur::class);
        $educateur = $educateur->find($id);
        
    
            $entityManager->remove($educateur);
            $entityManager->flush();
        

        
        $this->addFlash('delete', 'suppression effectué');
        return $this->redirectToRoute('app_educateur_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/send-email', name: 'send_email', methods: ['POST'])]

    public function sendmail(Request $request, MailerInterface $mailer, EducateurRepository $educateurRepository){
        
        // Récupérer les IDs des éducateurs sélectionnés depuis le formulaire
     $selectedEducateurs = $request->request->get('educateurs', []);

     // Récupérer les entités Educateur en fonction des IDs
    $educateurs = $educateurRepository->findBy(['id' => $selectedEducateurs]);

    // Envoyer un e-mail à chaque éducateur
    foreach ($educateurs as $educateur) {
        $email = (new Email())
            ->from('votre_email@example.com') // Remplacez par votre adresse e-mail
            ->to($educateur->getEmail())
            ->subject('Sujet de l\'e-mail')
            ->text('Contenu du message : Bonjour ' . $educateur->getPrenom() . '!');

        $mailer->send($email);
    }

    // Ajouter un message de succès ou de redirection après l'envoi des e-mails
    $this->addFlash('success', 'Les e-mails ont été envoyés avec succès.');

    return $this->redirectToRoute('app_mail_edu_index');


    }
}
