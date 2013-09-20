<?php

namespace Lks\ProjectManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lks\ProjectManagementBundle\Entity\Project;

class DefaultController extends Controller
{
    public function projectsAction(Request $request)
    {
    	//get all user items
        $repository = $this->getDoctrine()
            ->getRepository('LksProjectManagementBundle:Project');

        //begin of the form building
        $project = new Project();

        $form = $this->createFormBuilder($member)
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('Atribution', '')
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
            return $this->render('LksUserManagementBundle:Default:listUser.html.twig', array('members' => $members, 'form' => $form->createView()));
        }
        // The security layer will intercept this request
        return $this->render('LksUserManagementBundle:Default:listUser.html.twig', array('members' => $members, 'form' => $form->createView()));
    }
}
