<?php

namespace App\Controller;

use App\Entity\BathroomType;
use App\Entity\BuildingType;
use App\Entity\City;
use App\Entity\Flat;
use App\Entity\HeatingType;
use App\Entity\KitchenType;
use App\Entity\Region;
use App\Entity\WindowsType;
use App\Form\FlatType;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThan;

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

            return $this->redirectToRoute('homepage');
        }

        return $this->render('flat/new.html.twig',[
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

        return $this->render('flat/flat.html.twig',[
            'flat' => $flat
        ]);
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

        $filters = $this->get('form.factory')->createNamedBuilder('filters', FormType::class, [
            'csrf_protection' => null
        ])
            ->setMethod('get')
            ->add('flatType', EntityType::class,[
                'class' => \App\Entity\FlatType::class,
                'label' => 'Typ ogłoszenia',
                'multiple' => true,
                'expanded' => true,
                'required' => false
            ])
            ->add('buildingType', EntityType::class,[
                'class' => BuildingType::class,
                'label' => 'Typ budynku',
                'multiple' => true,
                'expanded' => true,
                'required' => false
            ])
            ->add('heatingType', EntityType::class,[
                'class' => HeatingType::class,
                'label' => 'Typ ogrzewania',
                'multiple' => true,
                'expanded' => true,
                'required' => false
            ])
            ->add('kitchenType', EntityType::class,[
                'class' => KitchenType::class,
                'label' => 'Typ kuchni',
                'multiple' => true,
                'expanded' => true,
                'required' => false
            ])
            ->add('bathroomType', EntityType::class,[
                'class' => BathroomType::class,
                'label' => 'Typ łazienki',
                'multiple' => true,
                'expanded' => true,
                'required' => false
            ])
            ->add('windowsType', EntityType::class,[
                'class' => WindowsType::class,
                'label' => 'Typ okien',
                'multiple' => true,
                'expanded' => true,
                'required' => false
            ])
            ->add('priceFrom', IntegerType::class, [
                'required' => false,
                'label' => 'Cena od',
                'attr' => ['min'=>1,'max'=>1000000],
            ])
            ->add('priceTo', IntegerType::class, [
                'required' => false,
                'label' => 'Cena do',
                'attr' => ['min'=>1,'max'=>1000000],
            ])
            ->getForm();
        $filters->handleRequest($request);
        $filtersArr = [];
        if($filters->isSubmitted() && $filters->isValid())
        {
            $data = $filters->getData();
            if($data['priceFrom'] != null) $filtersArr['priceFrom'] = $data['priceFrom'];
            if($data['priceTo'] != null) $filtersArr['priceTo'] = $data['priceTo'];
            if(count($data['flatType']) > 0) $filtersArr['flatType'] = $data['flatType'];
            if(count($data['buildingType']) > 0) $filtersArr['buildingType'] = $data['buildingType'];
            if(count($data['heatingType']) > 0) $filtersArr['heatingType'] = $data['heatingType'];
            if(count($data['kitchenType']) > 0) $filtersArr['kitchenType'] = $data['kitchenType'];
            if(count($data['windowsType']) > 0) $filtersArr['windowsType'] = $data['windowsType'];
        }

        $distanceFilter = $this->get('form.factory')->createNamedBuilder('d', FormType::class, [
            'csrf_protection' => null
        ])
            ->setMethod('get')
            ->add('lat',HiddenType::class, [
                'constraints' => [
                    new GreaterThan(['value'=>48]),
                    new LessThan(['value'=>55])
                ]
            ])
            ->add('lon', HiddenType::class, [
                'constraints' => [
                    new GreaterThan(['value'=>14]),
                    new LessThan(['value'=>24])
                ]
            ])
            ->add('dist', ChoiceType::class, [
                'label' => 'Szukaj w promieniu',
                'choices' => [
                    '1 km' => 1,
                    '5 km' => 5,
                    '10 km' => 10,
                    '20 km' => 20,
                    '30 km' => 30,
                    '40 km' => 40,
                    '50 km' => 50
                ]
            ])
            ->getForm();
        $distanceFilter->handleRequest($request);

        $distanceArr = [];
        if($distanceFilter->isSubmitted() && $distanceFilter->isValid())
        {
            $data = $distanceFilter->getData();
            if($data['dist'] != null && $data['lat'] != null && $data['lon'])
                $distanceArr = [
                    'dist' => $data['dist'],
                    'lat' => $data['lat'],
                    'lon' => $data['lon']
                ];
        }

        $flats = $this->objectManager->getRepository(Flat::class)->search(array_merge([
            'region' => $region,
            'city' => $city,
        ], $filtersArr, $distanceArr));
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
            'city' => $city,
            'filters' => $filters->createView(),
            'distanceFilter' => $distanceFilter->createView()
        ]);
    }
}
