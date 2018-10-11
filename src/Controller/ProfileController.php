<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;

class ProfileController extends AbstractController
{
    
    public function __construct(EventDispatcherInterface $eventDispatcher, UserManagerInterface $userManager)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->userManager = $userManager;
    }
    
    /**
     * @Route("/profile/", name="profile")
     */
    public function index(Request $request)
    {
        $user = $this->getUser();
        
        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class, array('label' => 'Ваш логин:', 'attr' => ['placeholder' => 'Ваш логин', 'class' => 'form-control', 'minlength' => '6'], 'constraints' => new Length(array('min' => 6))))
            ->add('firstname', TextType::class, array('label' => 'Ваше имя:', 'attr' => ['placeholder' => 'Ваше имя', 'class' => 'form-control', 'minlength' => '3'], 'constraints' => new Length(array('min' => 3))))
            ->add('middlename', TextType::class, array('label' => 'Ваше отчество:', 'attr' => ['placeholder' => 'Ваше отчество', 'class' => 'form-control', 'minlength' => '3'], 'constraints' => new Length(array('min' => 3))))
            ->add('secondname', TextType::class, array('label' => 'Ваша фамилия:', 'attr' => ['placeholder' => 'Ваша фамилия', 'class' => 'form-control', 'minlength' => '3'], 'constraints' => new Length(array('min' => 3))))
            ->add('email', EmailType::class, array('label' => 'Ваша почта:', 'attr' => ['placeholder' => 'Ваша почта', 'class' => 'form-control', 'minlength' => '3'], 'constraints' => new Length(array('min' => 3))))    
            ->add('save', SubmitType::class, array('label' => 'Сохранить', 'attr' => ['class' => 'btn btn-lg btn-success']))
            ->getForm();        

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $this->userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('profile');
                $response = new RedirectResponse($url);
            }

            $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }
        
        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        ));
    }
}
