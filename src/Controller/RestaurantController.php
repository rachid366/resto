<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Restaurant;
use App\Entity\City;
class RestaurantController extends AbstractController
{
    /**
     * @Route("/restaurant", name="app_restaurant")
     */
    public function index(): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'controller_name' => 'RestaurantController',
        ]);
    }

    /**
     * @Route("/restaurants", name="restaurant.index" , methods={"GET","POST"})
     */
    public function restaurants(ManagerRegistry $doctrine)
    {
        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
        return new Response(
            $this->renderView(
                "restaurant/restaurants.html.twig",
                [
                    "restaurants"=>$restaurants,
                ]
            )
        );
    }

    /**
     * @Route("/restaurant",name="restaurant.name" , methods={"POST"})
     */
public function create(Request $request, ManagerRegistry $doctrine)
{
    $entityManager = $doctrine->getManager();

    $city = $doctrine->getRepository(City::class)->find($request->get("cityId"));
    $restaurant = new Restaurant();
    $restaurant->setName($request->get("name"));
    $restaurant->setDescription($request->get("description"));
    $restaurant->setCreatedAt(new \DateTime());

    $restaurant->setCityId($city);
    $entityManager->persist($restaurant);
    $entityManager->flush();

    $image = $request->files->get('picture');
    $imageName = uniqid().".".$image->guessExtension();
    $image->move($this->getParameter("images_dir"), $imageName);
    $restaurantPicture = new RestaurantPicture();
    $restaurantPicture->setFilename($imageName);
    $restaurantPicture->setRestaurantId($restaurant);

    $entityManager->persist($restaurantPicture);
    $entityManager->flush();
    $this->addFlash("success", "Operation Successfully Completed");

    return $this->redirectToRoute("restaurant.index");
}

    /**
     * @Route("/restaurant/new",name="restaurant.new", methods={"GET"})
     */
    public function new(ManagerRegistry $doctrine)
    {
        $cities = $doctrine->getRepository(City::class)->findAll();

        return new Response(
            $this->renderView(
                "restaurant/index.html.twig",
                [
                    "cities" => $cities,
                ]
            )
        );
    }

    /**
     * @Route("/restaurants/{restaurant}",methods={"GET"})
     */
    public function restaurant($restaurant, ManagerRegistry $doctrine)
    {
        $restaurant = $doctrine->getRepository(Restaurant::class)->findOneBy(
            [
                "name" => $restaurant,
            ]
        );
        if ($restaurant != null) {
            dd("trouvé");
        } else {
            dd("pas trouvé");
        }
    }
}
