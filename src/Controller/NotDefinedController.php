<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotDefinedController extends AbstractController
{
    #[Route('/not/defined', name: 'app_not_defined')]
    public function index(): Response
    {
        return $this->render('not_defined/index.html.twig', [
            'controller_name' => 'NotDefinedController',
        ]);
    }
}
