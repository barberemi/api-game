<?php

namespace App\Controller;

use App\Manager\FightManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FightController
 *
 * @Route("/fights")
 */
class FightController extends AbstractController
{
    /**
     * @var FightManager
     */
    protected $fightManager;

    /**
     * FightController constructor.
     *
     * @param FightManager $fightManager
     */
    public function __construct(FightManager $fightManager)
    {
        $this->fightManager = $fightManager;
    }

    /**
     * Get a fight.
     *
     * @Route("/{id}/{toFight}", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get fight correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="fights")
     *
     * @param int $id
     * @param bool $toFight
     *
     * @return JsonResponse
     */
    public function index(int $id, bool $toFight)
    {
        try {
            if ($toFight) {
                $fightEntity = $this->fightManager->getObject($id);
                $fight = $this->fightManager->generateFight($fightEntity);
            } else {
                $fight = $this->fightManager->get($id);
            }
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($fight, JsonResponse::HTTP_OK);
    }

    /**
     * Get all fights.
     *
     * @Route(methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get all fights correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="fights")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function indexAll(Request $request)
    {
        try {
            $fights = $this->fightManager->getAll($request->query->all());
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($fights, JsonResponse::HTTP_OK);
    }

    /**
     * Create a fight.
     *
     * @Route(methods={"POST"})
     * @SWG\Response(
     *     response=201,
     *     description="When fight created correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="fight",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *     )
     * )
     * @SWG\Tag(name="fights")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        try {
            $fight = $this->fightManager->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($fight, JsonResponse::HTTP_CREATED);
    }

    /**
     * Update a fight.
     *
     * @Route("/{id}", methods={"PUT"})
     * @SWG\Response(
     *     response=200,
     *     description="When fight updated correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="fight",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="type", type="string", example="won")
     *     )
     * )
     * @SWG\Tag(name="fights")
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
            $fight = $this->fightManager->update($id, $data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($fight, JsonResponse::HTTP_OK);
    }

    /**
     * Delete a fight.
     *
     * @Route("/{id}", methods={"DELETE"})
     * @SWG\Response(
     *     response=200,
     *     description="When fight deleted correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="fights")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        try {
            $this->fightManager->delete($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_OK);
    }
}
