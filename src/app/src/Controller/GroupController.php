<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/{_locale}/group", "group_")
 */
class GroupController extends AbstractController
{


    /**
     * @Route(
     *     "/", name="index",
     *     format="json",
     *     requirements={
     *       "_format": "json",
     *       "_locale": "en|fr"
     *     }
     * )
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/GroupController.php',
        ]);
    }
}
