<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Uer;

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

    /**
     * @Route("/users", name="users.show")
     */
    public function users(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(uer::class)->findAll();
        return $this->render(
            'uer/index.html.twig',
            [
                'users' => $users
            ]
        );
    }
}
