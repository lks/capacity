<?php

namespace Lks\ProjectManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lks\ProjectManagementBundle\Entity\Project;
use Lks\MemberManagementBundle\Entity\Member;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    public function projectsAction(Request $request)
    {
    	//get all user items
        $repository = $this->getDoctrine()
            ->getRepository('LksProjectManagementBundle:Project');
        $projects = $repository->findAll();

        //begin of the form building
        $project = new Project();

        $form = $this->createFormBuilder($project)
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('estimation', 'integer')
            ->add('priority', 'choice', array(
                            'choices' => array('P1' => 'P1', 
                                    'P2' => 'P2',
                                    'P3' => 'P3')))
            // ->add('member', 'entity', array(
            //         'class' => 'LksMemberManagementBundle:Member',
            //         'property' => 'firstname',))
            ->add('save', 'submit')
            ->getForm();

        //mamage the response of the form
        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            $projects = $repository->findAll();

            //TODO : Define a route
            return $this->render('LksProjectManagementBundle:Default:projects.html.twig', array('projects' => $projects, 'form' => $form->createView()));
        }
        // The security layer will intercept this request
        return $this->render('LksProjectManagementBundle:Default:projects.html.twig', array('projects' => $projects, 'form' => $form->createView()));
    }

    public function deleteAction($projectId)
    {
        $repository = $this->getDoctrine()
            ->getRepository('LksProjectManagementBundle:Project');
        $project=$repository->find($projectId);
        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();

        return $this->redirect($this->generateUrl('lks_project_management_homepage'));
    }
}
