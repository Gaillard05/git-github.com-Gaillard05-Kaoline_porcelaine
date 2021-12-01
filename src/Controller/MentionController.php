<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MentionController extends AbstractController
{
    /**
     * @Route("/mention", name="mention")
     */
    public function mention(): Response
    {
        return $this->render('mention/mention.html.twig');
    }
}
