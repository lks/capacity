<?php

namespace Lks\UserManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lks\UserManagementBundle\Entity\Member;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function createAction(Request $request)
    {
    	$member = new Member();

    	$form = $this->createFormBuilder($member)
    		->add('firstname', 'text')
    		->add('lastname', 'text')
    		->add('save', 'submit')
    		->getForm();

    	//mamage the response of the form
    	$form->handleRequest($request);

    	if($form->isValid())
    	{
    		$em = $this->getDoctrine()->getManager();
		    $em->persist($member);
		    $em->flush();

		    //TODO : Define a route
		    return $this->render('LksUserManagementBundle:Default:yata.html.twig');
    	}

        return $this->render('LksUserManagementBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function listAndCreateAction(Request $request)
    {
        //get all user items
        $repository = $this->getDoctrine()
            ->getRepository('LksUserManagementBundle:Member');

        $members = $repository->findAll();

        //begin of the form building
        $member = new Member();

        $form = $this->createFormBuilder($member)
            ->add('firstname', 'text')
            ->add('lastname', 'text')
            ->add('save', 'submit')
            ->getForm();

        //mamage the response of the form
        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();

            //TODO : Define a route
            return $this->render('LksUserManagementBundle:Default:listUser.html.twig', array('members' => $members));
        }
        // The security layer will intercept this request
        return $this->render('LksUserManagementBundle:Default:listUser.html.twig', array('members' => $members, 'form' => $form));
    }
}
