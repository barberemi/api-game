<?php

namespace App\Controller;

use App\Repository\AggregatedDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MessageController
 *
 * @Route("/aggregated_data")
 */
class AggregatedDataController extends AbstractController
{
    /**
     * @var AggregatedDataRepository
     */
    protected $repository;

    /**
     * AggregatedDataController constructor.
     *
     * @param AggregatedDataRepository $repository
     */
    public function __construct(AggregatedDataRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get some aggregated data.
     *
     * @Route("/dashboard", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get all aggregated data correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="aggregated_data")
     *
     * @return JsonResponse
     */
    public function indexAll()
    {
        try {
            $data = $this->repository->getDashboardData();
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
}