<?php

namespace App\Controller;

use App\Entity\MailEdu;
use App\Form\MailEduType;
use App\Repository\MailEduRepository;
use App\Repository\EducateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Email;

#[Route('/mail/edu')]
class MailEduController extends AbstractController
{
    #[Route('/', name: 'app_mail_edu_index', methods: ['GET'])]
    public function index(MailEduRepository $mailEduRepository): Response
    {
       // dd($mailEduRepository->findAll());
        return $this->render('mail_edu/index.html.twig', [
            'mail_edus' => $mailEduRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mail_edu_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, EducateurRepository $educateurRepository): Response
{
    $mailEdu = new MailEdu();
    $form = $this->createForm(MailEduType::class, $mailEdu);
    $form->handleRequest($request);

    //dd($this->getUser());

    if ($form->isSubmitted() && $form->isValid()) {
        $educateurs = $form->get('educateur')->getData();

        foreach ($educateurs as $educateur) {
            $email = (new Email())
                ->from('admin@example.com') 
                ->to($educateur->getEmail())
                ->subject($form->get('objet')->getData())
                ->text($form->get('message')->getData())
                ->html('<p>See Twig integration for better HTML integration!</p>');

            $mailer->send($email);

            // Ajoutez l'éducateur au mail avant de le persister
            $mailEdu->addEducateur($educateur);
        }

        

        // Enregistrez le mail dans la base de données
        $mailEdu->setDateEnvoi(new \DateTime());
        $entityManager->persist($mailEdu);
        $entityManager->flush();

        $this->addFlash('success', 'Les e-mails ont été envoyés avec succès.');

        return $this->redirectToRoute('app_mail_edu_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('mail_edu/new.html.twig', [
        'mail_edu' => $mailEdu,
        'form' => $form,
    ]);
}

    #[Route('/{id}', name: 'app_mail_edu_show', methods: ['GET'])]
    public function show(MailEdu $mailEdu): Response
    {
        return $this->render('mail_edu/show.html.twig', [
            'mail_edu' => $mailEdu,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mail_edu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MailEdu $mailEdu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MailEduType::class, $mailEdu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mail_edu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mail_edu/edit.html.twig', [
            'mail_edu' => $mailEdu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mail_edu_delete', methods: ['POST'])]
    public function delete(Request $request, MailEdu $mailEdu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mailEdu->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mailEdu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mail_edu_index', [], Response::HTTP_SEE_OTHER);
    }
}
