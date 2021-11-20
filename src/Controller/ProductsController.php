<?php

namespace App\Controller;

use App\Entity\Pictures;
use App\Entity\Products;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsController extends AbstractController
{
    /**
     * @Route("/products", name="product_add")
     * @param Request $request
     * @return Response
     * 
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Products();
        $form = $this->createFormBuilder($product)
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'nom du produit',
                    'class' => 'form-control'
                ],
                'label' => 'Nom du produit'
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'description du produit',
                    'class' => 'form-control'
                ],
                'label' => 'Description du produit'
            ])
            ->add('categories', TextType::class, [
                "attr" => [
                    'placeholder' => 'catégorie du produit',
                    'class' => 'form-control'
                ],
                'label' => 'Catégorie des produits'
            ])
            ->add('prices', NumberType::class, [
                'attr' => [
                    'placeholder' => 'prix du produit',
                    'class' => 'form-control'
                ],
                'label' => 'Prix des produits'
            ])
            ->add('pictures', FileType::class, [
                'attr' => [
                    'placeholder' => 'images du produit',
                    'class' => 'form-control'
                ],
                'label' => 'Images du produit',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('ajouter', SubmitType::class, [
                'attr' => [
                    'class' => 'ajouter'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('catalogue');
        }

        return $this->render('products/product_add.html.twig', [
            'controller_name' => 'ProductsController',
            'title' => 'Ajouter un produit :',
            'form' => $form->createView(),
        ]);
    }
}
