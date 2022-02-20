<?php
namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/user", name="user_")
 */
class UserController extends AbstractController
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/", name="index")
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->userService->getUsers();
        return $this->json($result);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user) : JsonResponse
    {
        return new JsonResponse($this->userService->formatUser($user));
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param User $user
     * @return JsonResponse
     */
    public function delete(User $user): JsonResponse
    {
        return  new JsonResponse($this->userService->removeUser($user));
    }

    /**
     * @Route("/{id}", name="update", methods={"PUT"})
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function update(Request $request, User $user): JsonResponse
    {
        return new JsonResponse($this->userService->updateUser($user, $request->query->all()));
    }
}
