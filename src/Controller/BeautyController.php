<?php

namespace App\Controller;

use App\Entity\Beauty;
use App\Form\BeautyType;
use App\Repository\BeautyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/beauty')]
class BeautyController extends AbstractController
{
    #[Route('/{id}/details', name: 'app_bt_details')]
    public function prd(Beauty $beauty ):Response
    {
   
        return $this->render('beauty/afficherB.html.twig', [
            'beauty' => $beauty,
        ]);
    }
    #[Route('/', name: 'app_beauty_index', methods: ['GET'])]
    public function index(BeautyRepository $beautyRepository): Response
    {
        return $this->render('beauty/index.html.twig', [
            'beauties' => $beautyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_beauty_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BeautyRepository $beautyRepository): Response
    {
        $beauty = new Beauty();
        $form = $this->createForm(BeautyType::class, $beauty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $beautyRepository->save($beauty, true);

            return $this->redirectToRoute('app_beauty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('beauty/new.html.twig', [
            'beauty' => $beauty,
            'form' => $form,
        ]);
    }
    #[Route('/Beauty', name: 'page_beauty')]
    public function complement(BeautyRepository $beautyRepository ):Response
    {
   
        $beauties = $beautyRepository->findAll();
        return $this->render('beaute.html.twig' ,[
         'beauties' => $beauties
            
        ]);
    }
    #[Route('/{id}', name: 'app_beauty_show', methods: ['GET'])]
    public function show(Beauty $beauty): Response
    {
        return $this->render('beauty/show.html.twig', [
            'beauty' => $beauty,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_beauty_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Beauty $beauty, BeautyRepository $beautyRepository): Response
    {
        $form = $this->createForm(BeautyType::class, $beauty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $beautyRepository->save($beauty, true);

            return $this->redirectToRoute('app_beauty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('beauty/edit.html.twig', [
            'beauty' => $beauty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_beauty_delete', methods: ['POST'])]
    public function delete(Request $request, Beauty $beauty, BeautyRepository $beautyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$beauty->getId(), $request->request->get('_token'))) {
            $beautyRepository->remove($beauty, true);
        }

        return $this->redirectToRoute('app_beauty_index', [], Response::HTTP_SEE_OTHER);
    }
}
