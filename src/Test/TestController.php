<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/websocket")
     */
    public function index()
    {
        return $this->render('websocket.html.twig', [
            'controller_name' => 'WebsocketController',
        ]);
    }
}
