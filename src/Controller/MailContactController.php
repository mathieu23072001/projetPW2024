<?php

namespace App\Controller;

use App\Entity\MailContact;
use App\Form\MailContactType;
use App\Repository\MailContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mail/contact')]
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
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mailContact = new MailContact();
        $form = $this->createForm(MailContactType::class, $mailContact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mailContact);
            $entityManager->flush();

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

    #[Route('/{id}', name: 'app_mail_contact_delete', methods: ['POST'])]
    public function delete(Request $request, MailContact $mailContact, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mailContact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mailContact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mail_contact_index', [], Response::HTTP_SEE_OTHER);
    }
}
