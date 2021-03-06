<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use App\Handler\AuthenticationHandler;
use App\Entity\Categories;
use App\Entity\Statements;

class BaseController extends AbstractController
{         
    public function headerList()
    {
        $cat_rep = $this->getDoctrine()->getRepository(Categories::class);
        
        $categories = $cat_rep->findBy([
            'enable' => '1'
        ]);
        
        $defaultData = array('message' => 'Поиск по заявлениям');
        $form = $this->createFormBuilder($defaultData)
            ->setAction('/search')
            ->add('name', TextType::class, array('label' => false, 'attr' => ['placeholder' => 'Поиск по заявлениям', 'class' => 'form-control', 'minlength' => '3'], 'constraints' => new Length(array('min' => 3))))
            ->add('send', SubmitType::class, array('attr' => ['class' => 'btn btn-primary']))
            ->getForm();
        
        return $this->render('base/headerList.html.twig', [
            'categories' => $categories,
            'form' => $form->createView()
        ]);
    }
    
    /**
    * @Route("/search", name = "search")
    */
    public function search(Request $request)
    {
        $defaultData = array('message' => 'Поиск по заявлениям');
        $form = $this->createFormBuilder($defaultData)
            ->setAction('search')
            ->add('name', TextType::class, array('label' => false, 'constraints' => new Length(array('min' => 3))))
            ->add('send', SubmitType::class)
            ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $data = $form->getData();
            $stat_rep = $this->getDoctrine()->getRepository(Statements::class);
            $result = $stat_rep->createQueryBuilder('s')
                ->where('s.name LIKE :name')
                ->setParameter('name', '%' . $data['name'] . '%')
                ->getQuery();
            
            $statements = $result->execute(); 
            
            $request->request->set('search_widget', $data['name']);
            return $this->render('pages/search.html.twig',[
                'statements' => $statements
            ]);
        } else if(null !== $request->request->get('search_widget')){
            $stat_rep = $this->getDoctrine()->getRepository(Statements::class);
            $result = $stat_rep->createQueryBuilder('s')
                ->where('s.name LIKE :name')
                ->setParameter('name', '%' . $request->request->get('search_widget') . '%')
                ->getQuery();
            
            $statements = $result->execute(); 
            return $this->render('pages/search.html.twig',[
                'statements' => $statements
            ]);
        }
        
        foreach ($form->getErrors(true, false) as $error) {
            $errors[] = $error->current()->getMessage();
        }
        
        $this->get('session')->getFlashBag()->add('info', implode(',', $errors));
        return $this->redirectToRoute('homepage');
    }
    
    /**
    * @Route("/about", name = "about")
    */
    public function aboutUs()
    {
        return $this->render('base/about.html.twig');
    }
    
    public function getLastStatement()
    {
        $statement = $this->getDoctrine()->getRepository(Statements::class);
        
        $last_statement = $statement->findBy(
            array(),
            ['update_date' => 'ASC'],
            ['limit' => '1']
        );
        
        return $this->render('base/lastStatement.html.twig', [
            'statement' => $last_statement[0]
        ]);
    }
}
