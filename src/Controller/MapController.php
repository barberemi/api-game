<?php

namespace App\Controller;

use App\Manager\MapManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MapController
 *
 * @Route("/maps")
 */
class MapController extends AbstractController
{
    /**
     * @var MapManager
     */
    protected $mapManager;

    /**
     * MapController constructor.
     *
     * @param MapManager $mapManager
     */
    public function __construct(MapManager $mapManager)
    {
        $this->mapManager = $mapManager;
    }

    /**
     * Get a map.
     *
     * @Route("/{id}", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get map correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="maps")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function index(int $id)
    {
        try {
            $map = $this->mapManager->get($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($map, JsonResponse::HTTP_OK);
    }

    /**
     * Get all maps.
     *
     * @Route(methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get all maps correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="maps")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function indexAll(Request $request)
    {
        try {
            $maps = $this->mapManager->getAll($request->query->all());
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($maps, JsonResponse::HTTP_OK);
    }

    /**
     * Create a map.
     *
     * @Route(methods={"POST"})
     * @SWG\Response(
     *     response=201,
     *     description="When map created correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="map",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string", example="Aincard"),
     *         @SWG\Property(property="level", type="number", example=10),
     *     )
     * )
     * @SWG\Tag(name="maps")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        try {
            $this->mapManager->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }

    /**
     * Update a map.
     *
     * @Route("/{id}", methods={"PUT"})
     * @SWG\Response(
     *     response=200,
     *     description="When map updated correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="map",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string", example="Aincarde"),
     *         @SWG\Property(property="level", type="number", example=5),
     *     )
     * )
     * @SWG\Tag(name="maps")
     *
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(int $id, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        try {
            $map = $this->mapManager->update($id, $data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($map, JsonResponse::HTTP_OK);
    }

    /**
     * Delete a map.
     *
     * @Route("/{id}", methods={"DELETE"})
     * @SWG\Response(
     *     response=200,
     *     description="When map deleted correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="maps")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        try {
            $this->mapManager->delete($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_OK);
    }
}
