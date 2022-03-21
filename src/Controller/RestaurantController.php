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
     * @Route("/restaurants", name="restaurant.index" , methods={"GET","POST"})
     */
    public function restaurants(ManagerRegistry $doctrine)
    {
        $restaurants = $doctrine->getRepository(Restaurant::class)->findAll();
        return new Response(
            $this->renderView(
                "restaurant/restaurants.html.twig",
                [
                    "restaurants" => $restaurants,
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
        $restaurant->setCreatedAt(new \DateTimeImmutable('now'));

        $restaurant->setCityId($city);
        $entityManager->persist($restaurant);
        $entityManager->flush();
        return $this->redirectToRoute("restaurant.form");

    }

    /**
     * @Route("/restaurantForm",name="restaurant.form" , methods={"GET"})
     */
    public function form(Request $request, ManagerRegistry $doctrine)
    {
        $cities = $doctrine->getRepository(City::class)->findAll();
        return new Response(
            $this->renderView(
                "restaurant/create.html.twig",["cities"=>$cities]
            )
        );
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

    /**
     * @Route("/requete/1")
     */
    public function query1(ManagerRegistry $doctrine)
    {
        $restaurants = $doctrine->getRepository(Restaurant::class)->DerniersRestaurants(6);
        dd($restaurants);
    }

    /**
     * @Route("/requete/2")
     */
    public function query2(ManagerRegistry $doctrine)
    {
        $restaurant = $doctrine->getRepository(Restaurant::class)->find(1);
        $restaurants = $doctrine->getRepository(Restaurant::class)->ValeurMoyenne($restaurant);
        dd($restaurants);
    }

    /**
     * @Route("/requete/3")
     */
    public function query3(ManagerRegistry $doctrine)
    {
        $restaurants = $doctrine->getRepository(Restaurant::class)->meilleurs();
        dd($restaurants);
    }

    /**
     * @Route("/requete/4")
     */
    public function query4(ManagerRegistry $doctrine)
    {
        $restaurants = $doctrine->getRepository(Restaurant::class)->restaurantsDetails();
        dd($restaurants);
    }

    /**
     * @Route("/requete/5")
     */
    public function query5(ManagerRegistry $doctrine)
    {
        $restaurants = $doctrine->getRepository(Restaurant::class)->détails();
        dd($restaurants);
    }
}
