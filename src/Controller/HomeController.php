<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 */
class HomeController extends AbstractController
{
    /**
     * Home url
     *
     * @Route("/")
     *
     * @return JsonResponse
     */
    public function home()
    {
        return new JsonResponse(['ok' => 200], JsonResponse::HTTP_CREATED);
    }
}
