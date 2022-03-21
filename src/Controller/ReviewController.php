<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Review;

class ReviewController extends AbstractController
{
    /**
     * @Route("/review", name="app_review")
     */
    public function index(): Response
    {
        return $this->render('review/index.html.twig', [
            'controller_name' => 'ReviewController',
        ]);
    }

    /**
     * @Route("/review/store",name="review.store")
     */
    public function addReview(Request $request,ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $review = new Review();
        $review->setMessage($request->get("message"));
        $review->setRating($request->get("rating"));
        $review->setCreatedAt(new \DateTime());
        $restaurant = $doctrine->getRepository(Restaurant::class)->find($request->get("restaurantId"));
        $user = $doctrine->getRepository(User::class)->find($request->get("userId"));
        $review->setRestaurantId($restaurant);
        $review->setUserId($user);
        $entityManager->persist($review);
        $entityManager->flush();
        $this->addFlash("success","Operation Successfully Completed");

    }
}
