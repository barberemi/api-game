<?php

namespace App\Controller;

use App\Manager\SkillManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SkillController
 *
 * @Route("/skills")
 */
class SkillController extends AbstractController
{
    /**
     * @var SkillManager
     */
    protected $skillManager;

    /**
     * SkillController constructor.
     *
     * @param SkillManager $skillManager
     */
    public function __construct(SkillManager $skillManager)
    {
        $this->skillManager = $skillManager;
    }

    /**
     * Get a skill.
     *
     * @Route("/{id}", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get skill correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="skills")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function index(int $id)
    {
        try {
            $skill = $this->skillManager->get($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($skill, JsonResponse::HTTP_OK);
    }

    /**
     * Get all skills.
     *
     * @Route(methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get all skills correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="skills")
     *
     * @return JsonResponse
     */
    public function indexAll()
    {
        try {
            $skills = $this->skillManager->getAll();
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($skills, JsonResponse::HTTP_OK);
    }

    /**
     * Create a skill.
     *
     * @Route(methods={"POST"})
     * @SWG\Response(
     *     response=201,
     *     description="When skill created correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="skill",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string", example="Brise casque"),
     *         @SWG\Property(property="description", type="string", example="Permet de casser la tête de l'ennemi."),
     *         @SWG\Property(property="cost", type="number", example=50),
     *         @SWG\Property(property="cooldown", type="number", example=1),
     *         @SWG\Property(property="duration", type="number", example=3),
     *     )
     * )
     * @SWG\Tag(name="skills")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        try {
            $this->skillManager->create($data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }

    /**
     * Update a skill.
     *
     * @Route("/{id}", methods={"PUT"})
     * @SWG\Response(
     *     response=200,
     *     description="When skill updated correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Parameter(
     *     name="skill",
     *     in="body",
     *     required=true,
     *     description="JSON payload.",
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(property="name", type="string", example="Brise casque"),
     *         @SWG\Property(property="description", type="string", example="Permet de casser la tête de l'ennemi."),
     *         @SWG\Property(property="cost", type="number", example=50),
     *         @SWG\Property(property="cooldown", type="number", example=1),
     *         @SWG\Property(property="duration", type="number", example=3),
     *     )
     * )
     * @SWG\Tag(name="skills")
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
            $skill = $this->skillManager->update($id, $data);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($skill, JsonResponse::HTTP_OK);
    }

    /**
     * Delete a skill.
     *
     * @Route("/{id}", methods={"DELETE"})
     * @SWG\Response(
     *     response=200,
     *     description="When skill deleted correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="skills")
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        try {
            $this->skillManager->delete($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([], JsonResponse::HTTP_OK);
    }

    /**
     * Get all skills from specific academy/treeType.
     *
     * @Route("/academy/{academyId}/{treeType}", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="When get all skills correctly."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="When some errors on params."
     * )
     * @SWG\Tag(name="skills")
     *
     * @param int    $academyId
     * @param string $treeType
     *
     * @return JsonResponse
     */
    public function indexAllByAcademyAndType(int $academyId, string $treeType)
    {
        try {
            $map = $this->skillManager->getAllBy(['academy' => $academyId, 'treeType' => $treeType]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($map, JsonResponse::HTTP_OK);
    }
}
