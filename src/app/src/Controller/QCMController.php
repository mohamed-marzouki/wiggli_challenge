<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QCMController extends AbstractController
{
    /**
     * @Route("/qcm", name="q_c_m")
     */
    public function index(): Response
    {
        return $this->render('qcm/qcm.html.twig');
    }
}
