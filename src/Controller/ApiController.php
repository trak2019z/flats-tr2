<?php

namespace App\Controller;

use App\Entity\City;
use App\Helpers\Slugs;
use App\Repository\CityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/city-search", name="api_city_search")
     */
    public function index(Request $request, CityRepository $cityRepository)
    {
        $q = $request->query->get('q');

        $cities = $cityRepository->searchCity(['q'=>Slugs::create($q,'-')]);

        return $this->json(array_map(function (City $city){
            return [
                'id' => $city->getId(),
                'text' => (string)$city,
                'lat' => $city->getLat(),
                'lon' => $city->getLon()
            ];
        },$cities));
    }
}