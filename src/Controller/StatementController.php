<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Statements;
use App\Entity\StatementVars;

class StatementController extends AbstractController
{
    /**
     * @Route("/statement/{seo_path}", name="statement")
     */
    public function index($seo_path)
    {
        $repository = $this->getDoctrine()->getRepository(Statements::class);
        
        $statement = $repository->findOneBy(['seo_path' => $seo_path]);
                
        $var_list = $this->getStatementVars('id', $statement->getContent());
        
        return $this->render('statement/index.html.twig', [
            'controller_name' => 'StatementController',
            'statement' => $statement,
            'var_list' => $var_list
        ]);
    }
    
    function getStatementVars($word, $html)
    {
        $pattern = '~\[' . $word . '\](.*?)\[\/' . $word . '\]~';
        preg_match_all($pattern, $html, $matches);
        
        $repository = $this->getDoctrine()->getRepository(StatementVars::class);
        
        $statement_vars = $repository->findInTipValues($matches[1]);
        
        return $statement_vars;
    }
}
