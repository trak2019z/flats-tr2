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
    public function index(Request $request, ObjectManager $objectManager)
    {
        $flat = new Flat();
        $flat->setUser($this->getUser());
        $form = $this->createForm(FlatType::class, $flat);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            foreach ($flat->getRooms() as $room)
                $room->setFlat($flat);

            $objectManager->persist($flat);
            $objectManager->flush();
        }


        return $this->render('homepage.html.twig',[
            'form' => $form->createView()
        ]);
    }
}