<?php

namespace App\Controller;

use App\Form\FlatType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class Homepage extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(FlatType::class);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            dump($form->getData());
        }


        return $this->render('homepage.html.twig',[
            'form' => $form->createView()
        ]);
    }
}