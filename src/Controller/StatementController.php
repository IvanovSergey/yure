<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Statements;

class StatementController extends AbstractController
{
    /**
     * @Route("/statement/{seo_path}", name="statement")
     */
    public function index($seo_path)
    {
        $repository = $this->getDoctrine()->getRepository(Statements::class);
        
        $statement = $repository->findOneBy(['seo_path' => $seo_path]);
        
        return $this->render('statement/index.html.twig', [
            'controller_name' => 'StatementController',
            'statement' => $statement,
        ]);
    }
}
