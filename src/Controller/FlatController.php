<?php

namespace App\Controller;

use App\Entity\Flat;
use App\Form\FlatType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ogloszenia")
 */
class FlatController extends AbstractController
{
    /**
     * @Route("/dodaj-nowe", name="flat_create")
     * @IsGranted("ROLE_USER")
     */
    public function index(Request $request, ObjectManager $objectManager)
    {
        $flat = new Flat();
        $flat->setUser($this->getUser());
        $form = $this->createForm(FlatType::class, $flat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
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
