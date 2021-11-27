<?php

namespace App\Controller;

use Twig\Environment;
// use App\Entity\Products;
use App\Entity\Pictures;
use App\Entity\Products;
use App\Repository\ProductsRepository;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatalogueController extends AbstractController
{
    /**
     * @Route("/catalogue", name="catalogue")
     */
    public function catalogue(Environment $twig, ProductsRepository $productsRepository): Response
    {
        // //on récupère les images
        // $photos = $this->getDoctrine()->getRepository(Pictures::class)->findAll();

        return new Response($twig->render('catalogue/catalogue.html.twig', [
            'products' => $productsRepository->findAll(),
            'title' => 'Catalogue',
            // 'photos' => $photos
        ]));
    }
    /**
     * @Route("/catalogue/{id}", name="catalogue_show")
     */

    public function show(Environment $twig, Products $products,  ProductsRepository $productsRepository): Response
    {
        return new Response($twig->render('catalogue/show.html.twig', [
            'product' => $products

        ]));
    }
}
