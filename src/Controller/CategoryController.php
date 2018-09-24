<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categories;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{seo_path}", name="category")
     */
    public function index($seo_path)
    {
        $repository = $this->getDoctrine()->getRepository(Categories::class);
        
        $category = $repository->findOneBy(['seo_path' => $seo_path]);
        
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'category' => $category,
        ]);
    }
}
