<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Categories;
use App\Entity\Statements;

class HomeController extends AbstractController
{
    /**
    * @Route("/", name = "homepage")
    */
    public function Home()
    {
        $cat_rep = $this->getDoctrine()->getRepository(Categories::class);
        
        $categories = $cat_rep->findBy([
            'enable' => '1'
        ]);
        
        $stat_rep = $this->getDoctrine()->getRepository(Statements::class);
        
        $statements = $stat_rep->findBy([
            'enable' => '1'
        ],[
            'update_date' => 'DESC'
        ], 6);

        return $this->render('pages/home.html.twig', [
            'categories' => $categories,
            'statements' => $statements
        ]);
    }
}