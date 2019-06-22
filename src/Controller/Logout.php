<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class Logout extends AbstractController
{
    /**
     * @Route("/logout", name="logout_url")
     */
    public function index(SessionInterface $session)
    {
        $session->clear();
        return $this->redirectToRoute('homepage');
    }
}