<?php

namespace App\Controller;

use App\Service\GroupService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route(
     *     "/", name="index",
     *     format="json",
     *     requirements={
     *       "_format": "json"
     *     }
     * )
     */
    public function index(): Response
    {
        $this->groupService->getGroups();
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/GroupController.php',
        ]);
    }
}
