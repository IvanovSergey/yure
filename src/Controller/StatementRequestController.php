<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\StatementRequest;

class StatementRequestController extends AbstractController
{
    /**
     * @Route("/requestStatement", name="statement_request", methods={"POST"})
     */
    public function index(Request $request)
    {   
        $defaultData = array('message' => 'Заявка на заявление');
        $form = $this->createFormBuilder($defaultData)
            ->add('text', TextAreaType::class, array('attr' => ['class' => 'form-control']))
            ->add('send', SubmitType::class, array('attr' => ['class' => 'btn btn-primary']))
            ->getForm();
        
        $form->handleRequest($request);
        
        if (!empty($request->request->get('text'))) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $statement_request = new StatementRequest();
            $statement_request->setText($request->request->get('text'));
            $statement_request->setUser($this->getUser());
            $statement_request->setDatePosted(new \DateTime());
            

            $entityManager->persist($statement_request);

            $entityManager->flush();
            
            return new Response(
                'Ваша заявка принята'
            );
        }
        
        return $this->render('statement_request/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
