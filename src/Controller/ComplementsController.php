<?php

namespace App\Controller;

use App\Entity\Complements;
use App\Form\ComplementsType;
use App\Repository\ComplementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/complements')]
class ComplementsController extends AbstractController
{

    #[Route('/{id}/details', name: 'app_comp_details')]
    public function prd(Complements $complement ):Response
    {
   
        return $this->render('complements/affichercomp.html.twig', [
            'complement' => $complement,
        ]);
    }

    #[Route('/', name: 'app_complements_index', methods: ['GET'])]
    public function index(ComplementsRepository $complementsRepository): Response
    {
        return $this->render('complements/index.html.twig', [
            'complements' => $complementsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_complements_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ComplementsRepository $complementsRepository): Response
    {
        $complement = new Complements();
        $form = $this->createForm(ComplementsType::class, $complement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $complementsRepository->save($complement, true);

            return $this->redirectToRoute('app_complements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('complements/new.html.twig', [
            'complement' => $complement,
            'form' => $form,
        ]);
    }
    #[Route('/complement', name: 'page_complement')]
    public function complement(ComplementsRepository $complementsRepository ):Response
    {
   
        $complements = $complementsRepository->findAll();
        return $this->render('compléments.html.twig' ,[
         'complements' => $complements
            
        ]);
    }

    #[Route('/{id}', name: 'app_complements_show', methods: ['GET'])]
    public function show(Complements $complement): Response
    {
        return $this->render('complements/show.html.twig', [
            'complement' => $complement,
        ]);
    }

    

    #[Route('/{id}/edit', name: 'app_complements_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Complements $complement, ComplementsRepository $complementsRepository): Response
    {
        $form = $this->createForm(ComplementsType::class, $complement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $complementsRepository->save($complement, true);

            return $this->redirectToRoute('app_complements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('complements/edit.html.twig', [
            'complement' => $complement,
            'form' => $form,
        ]);
    }
   

    #[Route('/{id}', name: 'app_complements_delete', methods: ['POST'])]
    public function delete(Request $request, Complements $complement, ComplementsRepository $complementsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$complement->getId(), $request->request->get('_token'))) {
            $complementsRepository->remove($complement, true);
        }

        return $this->redirectToRoute('app_complements_index', [], Response::HTTP_SEE_OTHER);
    }
}
