<?php

namespace Lks\CapacityManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Lks\CapacityManagementBundle\Entity\Project;
use Lks\CapacityManagementBundle\Services\ProjectService;
use Lks\CapacityManagementBundle\Entity\Member;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    public function projectsAction(Request $request)
    {
    	//get all user items
        $repository = $this->getDoctrine()
            ->getRepository('LksCapacityManagementBundle:Project');
        $projects = $repository->findAll();

        //begin of the form building
        $project = new Project();

        $form = $this->createFormBuilder($project)
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('estimation', 'integer')
            ->add('beginDate', 'date')
            ->add('priority', 'choice', array(
                            'choices' => array('P1' => 'P1', 
                                    'P2' => 'P2',
                                    'P3' => 'P3')))
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
            return $this->render('LksCapacityManagementBundle:Default:projects.html.twig', array('projects' => $projects, 'form' => $form->createView()));
        }
        // The security layer will intercept this request
        return $this->render('LksCapacityManagementBundle:Default:projects.html.twig', array('projects' => $projects, 'form' => $form->createView()));
    }

    public function editAction($projectId, Request $request)
    {
        $projectService = $this->get('projectService');

        $repository = $this->getDoctrine()
            ->getRepository('LksCapacityManagementBundle:Project');
        $project=$repository->find($projectId);

        $form = $this->createFormBuilder($project)
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('estimation', 'integer')
            ->add('priority', 'choice', array(
                            'choices' => array('P1' => 'P1', 
                                    'P2' => 'P2',
                                    'P3' => 'P3')))
            ->add('member', 'entity', array(
                     'class' => 'LksCapacityManagementBundle:Member',
                     'property' => 'firstname',))
            ->add('save', 'submit')
            ->getForm();

         //mamage the response of the form
        $form->handleRequest($request);

        if($form->isValid())
        {
            $projectService->updateProject($project);

            //TODO : Define a route
            return $this->redirect($this->generateUrl('lks_projects'));
        }
        return $this->render('LksCapacityManagementBundle:Default:edit.html.twig', array('project' => $project, 'form' => $form->createView()));
    }

    public function deleteAction($projectId)
    {
        $repository = $this->getDoctrine()
            ->getRepository('LksCapacityManagementBundle:Project');
        $project=$repository->find($projectId);
        $em = $this->getDoctrine()->getManager();
        $em->remove($project);
        $em->flush();

        return $this->redirect($this->generateUrl('lks_project_management_homepage'));
    }

    public function assignAction($projectId, Request $request)
    {
        $projectService = $this->get('projectService');

        $repository = $this->getDoctrine()
            ->getRepository('LksCapacityManagementBundle:Project');
        $project=$repository->find($projectId);

        $form = $this->createFormBuilder($project)
            ->add('name', 'text')
            ->add('member', 'entity', array(
                'class' => 'LksCapacityManagementBundle:Member',
                'property' => 'firstname'))
            ->add('Assign', 'submit')
            ->getForm();

        //mamage the response of the form
        $form->handleRequest($request);

        if($form->isValid())
        {
            $projectService->updateProject($project);

            //TODO : Define a route
            return $this->redirect($this->generateUrl('lks_capacity'));
        }
        // The security layer will intercept this request
        return $this->render('LksCapacityManagementBundle:Projects:assign.html.twig', array('project' => $project, 'form' => $form->createView()));
    }
}
