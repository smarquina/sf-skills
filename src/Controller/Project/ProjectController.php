<?php

namespace App\Controller\Project;

use App\Entity\Project\Project;
use App\Form\Project\AddProjectType;
use App\Service\Project\Add\AddProjectRequest;
use App\Service\Project\Add\AddProjectService;
use App\Service\Project\List\ListProjectsRequest;
use App\Service\Project\List\ListProjectsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/project')]
class ProjectController extends AbstractController {

    #[
        Route('/', name: 'project_index', defaults: ['page' => '1'], methods: ['GET']),
        Route('/page/{page<[1-9]\d*>}', name: 'project_index_paginated', methods: ['GET']),
    ]
    public function index(Request $request, int $page, ListProjectsService $service): Response
    {
        if ($request->query->has('name')){
            $name = $request->query->get('name');
        }

        $paginator = $service->handle(
            new ListProjectsRequest(page: $page, name: $name ?? null)
        );

        return $this->render('project/project_index.html.twig', compact('paginator'));
    }

    /**
     * Creates a new project entity.
     *
     * @param \Symfony\Component\HttpFoundation\Request  $request
     * @param \App\Service\Project\Add\AddProjectService $service
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/new', name: 'project_add', methods: ['GET', 'POST'])]
    public function add(Request $request, AddProjectService $service): Response
    {
        $project = Project::fromEmptyProject();
        $form    = $this->createForm(AddProjectType::class, $project)
                        ->add('saveAndCreateNew', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $service->handle(
                new AddProjectRequest($project->getName(),
                                      $project->getAmount(),
                                      $project->getStartDate())
            );


            $this->addFlash('success', 'post.created_successfully');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('project_add');
            }

            return $this->redirectToRoute('project_index');
        }

        return $this->render('project/project_add.html.twig', [
            'project' => $project,
            'form'    => $form->createView(),
        ]);
    }
}
