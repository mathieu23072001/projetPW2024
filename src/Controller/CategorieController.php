<?php

namespace App\Controller;
use App\Entity\Categorie;
use App\Entity\Licencie;
use App\Form\CategorieType;
use App\Repository\LicencieRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/categorie')]
class CategorieController extends AbstractController
{
    #[Route('/', name: 'app_categorie_index', methods: ['GET'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/contact/show/{id}', name: 'app_cat_contact_show', methods: ['GET'])]
public function contactShow(int $id, LicencieRepository $licencieRepository,CategorieRepository $categorieRepository): Response
{
    
    $categorie = $categorieRepository->find($id);

    if (!$categorie) {
        throw $this->createNotFoundException('Catégorie non trouvée');
    }

    
    $licencies = $licencieRepository->findBy(['categorie' => $categorie]);

    
    $contacts = [];

    
    foreach ($licencies as $licencie) {
        $contact = $licencie->getContact();

        
        if ($contact && !in_array($contact, $contacts, true)) {
            $contacts[] = $contact;
        }
    }

    return $this->render('contact/index.html.twig', [
        'contacts' => $contacts,
    ]);
}

    #[Route('/licencie/show/{id}', name: 'app_cat_licencie_show', methods: ['GET'])]
    public function licencieShow(int $id, CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->find($id);

        if (!$categorie) {
            return new Response("La catégorie avec l'ID $id n'a pas été trouvée", Response::HTTP_NOT_FOUND);
        }
        $licencies = $categorie->getLicencies();
        
       
        return $this->render('licencie/index.html.twig', [
            'licencies' => $licencies,
        ]);
    }

    #[Route('/new', name: 'app_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            $this->addFlash('success', 'enregistrement effectué');
            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_show', methods: ['GET'])]
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            $this->addFlash('modify', 'modification effectué');
            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categorie/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_categorie_delete',  methods: ['GET', 'POST'])]
    public function delete( $id, EntityManagerInterface $entityManager): Response
    {

        $categorie = $entityManager->getRepository(Categorie::class);
        $categorie = $categorie->find($id);
        
    
            $entityManager->remove($categorie);
            $entityManager->flush();
        

        
        $this->addFlash('delete', 'suppression effectué');
        return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
    }



    
}
