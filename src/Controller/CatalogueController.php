<?php

namespace App\Controller;

use App\Entity\Pictures;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\PersistentCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CatalogueController extends AbstractController
{
    /**
     * @Route("/catalogue", name="catalogue")
     */
    public function catalogue(): Response
    {
        //on récupère les images
        $photos = $this->getDoctrine()->getRepository(Pictures::class)->findAll();


        return $this->render('catalogue/catalogue.html.twig', [
            'controller_name' => 'CatalogueController',
            'title' => 'Catalogue',
            'photos' => $photos
        ]);
    }
}
