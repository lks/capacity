<?php

namespace Lks\MemberManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lks\MemberManagementBundle\Entity\Member;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MemberController extends Controller
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
		    return $this->render('LksMemberManagementBundle:Default:yata.html.twig');
    	}

        return $this->render('LksMemberManagementBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function membersAction(Request $request)
    {
        //get all user items
        $repository = $this->getDoctrine() 
            ->getRepository('LksMemberManagementBundle:Member');

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

            $members = $repository->findAll();
            //TODO : Define a route
            return $this->render('LksMemberManagementBundle:Default:listUser.html.twig', array('members' => $members, 'form' => $form->createView()));
        }
        // The security layer will intercept this request
        return $this->render('LksMemberManagementBundle:Default:listUser.html.twig', array('members' => $members, 'form' => $form->createView()));
    }

    public function deleteAction($memberId)
    {
        $repository = $this->getDoctrine()
            ->getRepository('LksMemberManagementBundle:Member');
        $member=$repository->find($memberId);
        
        if($member != null)
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($member);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lmm_homepage'));
    }
}
