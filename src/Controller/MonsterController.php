<?php

namespace App\Controller;

use App\Manager\MonsterManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MonsterController
 *
 * @Route("/monsters")
 */
class MonsterController extends AbstractController
{
    /**
     * @var MonsterManager
     */
    protected $monsterManager;

    /**
     * MonsterController constructor.
     *
     * @param MonsterManager $monsterManager
     */
    public function __construct(MonsterManager $monsterManager)
    {
        $this->monsterManager = $monsterManager;
    }

    /**
     * Get a monster.
     *
     * @Route("/{id}", methods={"GET"})
     * @SWG\Response(
     *     response=201,
     *     description="When get monster correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="monsters")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function index(int $id)
    {
        try {
            $monster = $this->monsterManager->get($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($monster, JsonResponse::HTTP_CREATED);
    }

    /**
     * Create a monster.
     *
     * @Route(methods={"POST"})
     * @SWG\Response(
     *     response=201,
     *     description="When monster created correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="monster",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string", example="Méchant Grobébou"),
     *     )
     * )
     * @SWG\Tag(name="monsters")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        try {
            $this->monsterManager->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }

    /**
     * Update a monster.
     *
     * @Route("/{id}", methods={"PUT"})
     * @SWG\Response(
     *     response=200,
     *     description="When monster updated correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="monster",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string", example="Méchant Grobibou"),
     *     )
     * )
     * @SWG\Tag(name="monsters")
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
            $this->monsterManager->update($id, $data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_OK);
    }

    /**
     * Delete a monster.
     *
     * @Route("/{id}", methods={"DELETE"})
     * @SWG\Response(
     *     response=200,
     *     description="When monster deleted correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="monsters")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        try {
            $this->monsterManager->delete($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_OK);
    }
}
