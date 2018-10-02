<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Statements;
use App\Entity\StatementComments;

class StatementCommentsController extends AbstractController
{
    /**
     * @Route("/statementComments", name="statement_comments", methods={"POST"})
     */
    public function index(Request $request)
    {  
        
        if (!empty($request->request->get('text'))) {
            
            $statement = $this->getDoctrine()
                ->getRepository(Statements::class)
                ->find($request->request->get('statement_id'));
            
            $entityManager = $this->getDoctrine()->getManager();
            $statement_comment = new StatementComments();
            $statement_comment->setText($request->request->get('text'));
            $statement_comment->setUser($this->getUser());
            $statement_comment->setStatement($statement);
            $statement_comment->setCreateDate(new \DateTime());
            $statement_comment->setApproved(false);

            $entityManager->persist($statement_comment);

            $entityManager->flush();
            
            return new Response(
                'После проверки ваш комментарий будет отображен.'
            );
        }
    }
}
