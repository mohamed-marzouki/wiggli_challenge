<?php

namespace App\Controller;

use App\Service\GroupService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/group", "group_")
 */
class GroupController extends AbstractController
{
    private GroupService $groupService;

    /**
     * @param GroupService $groupService
     */
    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    /**
     * @Route("/", name="index")
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->groupService->getGroups();
        return $this->json($result);
    }

    /**
     * @Route("/new", name="new", methods={"POST"})
     * @return JsonResponse
     */
    public function new(Request $request): JsonResponse
    {
        return $this->json($this->groupService->addGroup($request->request->get('group')));
    }
}
