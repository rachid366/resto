<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UerController extends AbstractController
{
    /**
     * @Route("/uer", name="app_uer")
     */
    public function index(): Response
    {
        return $this->render('uer/index.html.twig', [
            'controller_name' => 'UerController',
        ]);
    }
}
