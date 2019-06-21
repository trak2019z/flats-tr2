<?php

namespace App\Controller;

use App\Entity\Flat;
use App\Form\FlatType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class Homepage extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(ObjectManager $objectManager)
    {
        $flats = $objectManager->getRepository(Flat::class)->search()->setMaxResults(4)->getResult();

        return $this->render('homepage.html.twig',[
            'flats' => $flats
        ]);
    }
}