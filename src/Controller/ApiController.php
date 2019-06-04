<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Flat;
use App\Helpers\Helpers;
use App\Helpers\Slugs;
use App\Repository\CityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * @Route("/uploadPhoto")
     * @IsGranted("ROLE_USER")
     */
    function uploadPhoto(Request $request, ValidatorInterface $validator, KernelInterface $kernel)
    {
        if($request->files->has('photo'))
        {
            /**
             * @var UploadedFile $photo
             */
            $photo = $request->files->get('photo');
            $c = $validator->validate($photo, [new Image()]);
            if($c->count()==0 && $photo->guessExtension())
            {
                $filename = Helpers::randomString().'.'.$photo->guessExtension();
                $photo->move($kernel->getProjectDir().'/public'.Flat::PHOTO_WEB_PATH,$filename);
                return $this->json(['filename'=>$filename]);
            }
        }

        return $this->json([]);
    }
}