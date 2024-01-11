<?php

namespace App\Controller;

use App\Entity\MailEdu;
use App\Form\MailEduType;
use App\Repository\MailEduRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mail/edu')]
class MailEduController extends AbstractController
{
    #[Route('/', name: 'app_mail_edu_index', methods: ['GET'])]
    public function index(MailEduRepository $mailEduRepository): Response
    {
        return $this->render('mail_edu/index.html.twig', [
            'mail_edus' => $mailEduRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mail_edu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mailEdu = new MailEdu();
        $form = $this->createForm(MailEduType::class, $mailEdu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mailEdu);
            $entityManager->flush();

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
