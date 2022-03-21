<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\Uer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Review;

class ReviewController extends AbstractController
{
    /**
     * @Route("/review", name="formulaire")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        //users
        $users = $doctrine->getRepository(Uer::class)->findAll();
        //restualts
        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
        return $this->render('review/index.html.twig', [
            "users"=>$users,
            "restaurants"=>$restaurants
        ]);
    }

    /**
     * @Route("/review/store",name="review.store")
     */
    public function addReview(Request $request,ManagerRegistry $doctrine)
    {
        $review = new Review();
        $review->setMessage($request->get("message"));
        $review->setRating($request->get("rating"));
        $review->setCreatedAt(new \DateTimeImmutable());
        $rest = $doctrine->getRepository(Restaurant::class)->find($request->get("restaurantId"));
        $user = $doctrine->getRepository(Uer::class)->find($request->get("userId"));
        $review->setRestaurantId($rest);
        $review->setUerId($user);
        $doctrine->getManager()->persist($review);
        $doctrine->getManager()->flush();
        return $this->redirectToRoute("formulaire");
    }
}
