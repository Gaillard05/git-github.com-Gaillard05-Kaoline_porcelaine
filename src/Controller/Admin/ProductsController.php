<?php

namespace App\Controller\Admin;

use App\Entity\Pictures;
use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsController extends AbstractController
{
    /**
     * @Route("admin/products/new", name="products_create")
     * @Route("admin/products/{id}/edit", name="products_edit")
     * @package App\Controller\Admin
     * @param Request $request
     * @return Response
     * 
     */
    public function form(Products $product = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$product) {
            $product = new Products();
        }

        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$product->getId()) {
                //On récupère les images transmises
                $images = $form->get('pictures')->getData();

                //On parcourt le tableau d'images  
                foreach ($images as $image) {
                    //généré un nouveau nom de fichier
                    $file = md5(uniqid()) . '.' . $image->guessExtension();

                    //On copie le fichier dans un dossier upload
                    $image->move(
                        $this->getParameter('upload_directory'),
                        $file
                    );

                    //on stocke l'image dans la base (son nom)
                    $img = new Pictures();
                    $img->setName($file);
                    $product->addPicture($img);
                }

                $entityManager->persist($product);
                $entityManager->flush();

                return $this->redirectToRoute('catalogue');
            }


            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('catalogue_show', ['id' => $product->getId()]);
        }

        return $this->render('admin/products/create.html.twig', [
            'controller_name' => 'ProductsController',
            'title' => 'Ajouter un produit :',
            'form' => $form->createView(),
            'editMode' => $product->getId() !== null
        ]);
    }
}
