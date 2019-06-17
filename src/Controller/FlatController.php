<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Flat;
use App\Entity\Region;
use App\Form\FlatType;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ogloszenia")
 */
class FlatController extends AbstractController
{
    private $objectManager;
    private $paginator;

    public function __construct(ObjectManager $objectManager, PaginatorInterface $paginator)
    {
        $this->objectManager = $objectManager;
        $this->paginator = $paginator;
    }

    /**
     * @Route("/dodaj-nowe", name="flat_create")
     * @IsGranted("ROLE_USER")
     */
    public function addNew(Request $request)
    {
        $flat = new Flat();
        $flat->setUser($this->getUser());
        $form = $this->createForm(FlatType::class, $flat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            foreach ($flat->getRooms() as $room)
                $room->setFlat($flat);

            $this->objectManager->persist($flat);
            $this->objectManager->flush();
        }

        return $this->render('homepage.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/pokaz/{slug<[a-z0-9\-]+>}-{flat}", name="flat_show")
     */
    public function show(Flat $flat, $slug)
    {
        if($flat->getSlug() != $slug)
            return $this->redirectToRoute('flat_show',[
                'slug' => $flat->getSlug(),
                'id'=> $flat->getId()
            ]);

        return $this->json([]);
    }

    /**
     * @Route("/", name="flats_listing")
     * @Route("/{regionSlug}", name="flats_listing_region")
     * @Route("/{regionSlug}/{citySlug}", name="flats_listing_region_city")
     */
    public function listing($regionSlug=null,$citySlug=null, Request $request)
    {
        $region = null;
        if($regionSlug!==null)
        {
            $region = $this->objectManager->getRepository(Region::class)->findOneBy(['slug'=>$regionSlug]);
            if(!$region)
                throw new NotFoundHttpException();
        }

        $city = null;
        if($citySlug!==null)
        {
            $city = $this->objectManager->getRepository(City::class)->findOneBy(['region'=>$region,'slug'=>$citySlug]);
            if(!$city)
                throw new NotFoundHttpException();
        }

        $flats = $this->objectManager->getRepository(Flat::class)->search([
            'region' => $region,
            'city' => $city,
        ]);

        /**
         * @var Flat[] $pagination
         */
        $pagination = $this->paginator->paginate(
            $flats,
            $request->query->getInt('p',1),
            10
        );

        return $this->render('flat/listing.html.twig',[
            'flats' => $pagination,
            'region' => $region,
            'regions' => $this->objectManager->getRepository(Region::class)->findBy([],['name'=>'asc']),
            'city' => $city
        ]);
    }
}
