<?php

namespace App\Controller;

use App\Manager\ConstructionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ConstructionController
 *
 * @Route("/constructions")
 */
class ConstructionController extends AbstractController
{
    /**
     * @var ConstructionManager
     */
    protected $constructionManager;

    /**
     * ConstructionController constructor.
     *
     * @param ConstructionManager $constructionManager
     */
    public function __construct(ConstructionManager $constructionManager)
    {
        $this->constructionManager = $constructionManager;
    }

    /**
     * Get all constructions.
     *
     * @Route(methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get all constructions correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="constructions")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function indexAll(Request $request)
    {
        try {
            $constructions = $this->constructionManager->getAll($request->query->all());
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($constructions, JsonResponse::HTTP_OK);
    }

    /**
     * Update a construction.
     *
     * @Route("/giveData/{id}", methods={"PUT"})
     * @SWG\Response(
     *     response=200,
     *     description="When construction updated correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="construction",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="type", type="string", example="action")
     *     )
     * )
     * @SWG\Tag(name="constructions")
     *
     * @param int $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function giveActionOrMaterial(int $id, Request $request)
    {
        $data = json_decode($request->getContent(), true);

        try {
            $user = $this->getUser();
            if (!$user){
                throw new \Exception('Needed to be connected to do this action.');
            }

            $construction = $this->constructionManager->giveActionOrMaterial($id, $user, $data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($construction, JsonResponse::HTTP_OK);
    }
}
