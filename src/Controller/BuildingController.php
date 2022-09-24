<?php

namespace App\Controller;

use App\Manager\BuildingManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BuildingController
 *
 * @Route("/buildings")
 */
class BuildingController extends AbstractController
{
    /**
     * @var BuildingManager
     */
    protected $buildingManager;

    /**
     * BuildingController constructor.
     *
     * @param BuildingManager $buildingManager
     */
    public function __construct(BuildingManager $buildingManager)
    {
        $this->buildingManager = $buildingManager;
    }

    /**
     * Get a building.
     *
     * @Route("/{id}", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get building correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="buildings")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function index(int $id)
    {
        try {
            $building = $this->buildingManager->get($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($building, JsonResponse::HTTP_OK);
    }

    /**
     * Get all buildings.
     *
     * @Route(methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get all buildings correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="buildings")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function indexAll(Request $request)
    {
        try {
            $buildings = $this->buildingManager->getAll($request->query->all());
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($buildings, JsonResponse::HTTP_OK);
    }

    /**
     * Create a building.
     *
     * @Route(methods={"POST"})
     * @SWG\Response(
     *     response=201,
     *     description="When building created correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="building",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string", example="caserne"),
     *         @SWG\Property(property="label", type="string", example="Caserne"),
     *         @SWG\Property(property="description", type="string", example="Description de la caserne"),
     *     )
     * )
     * @SWG\Tag(name="buildings")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        try {
            $building = $this->buildingManager->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($building, JsonResponse::HTTP_CREATED);
    }

    /**
     * Update a building.
     *
     * @Route("/{id}", methods={"PUT"})
     * @SWG\Response(
     *     response=200,
     *     description="When building updated correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="building",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="label", type="string", example="Nouvelle caserne")
     *     )
     * )
     * @SWG\Tag(name="buildings")
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
            $building = $this->buildingManager->update($id, $data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($building, JsonResponse::HTTP_OK);
    }

    /**
     * Delete a building.
     *
     * @Route("/{id}", methods={"DELETE"})
     * @SWG\Response(
     *     response=200,
     *     description="When building deleted correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="buildings")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        try {
            $this->buildingManager->delete($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_OK);
    }
}
