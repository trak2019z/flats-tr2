<?php

namespace App\Controller;

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

    }
}