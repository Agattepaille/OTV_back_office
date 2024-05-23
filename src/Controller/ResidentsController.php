<?php

namespace App\Controller;

use App\Entity\Residents;
use App\Form\ResidentsType;
use App\Repository\ResidentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/residents')]
class ResidentsController extends AbstractController
{
    #[Route('/', name: 'app_residents_index', methods: ['GET'])]
    public function index(ResidentsRepository $residentsRepository): Response
    {
        return $this->render('residents/index.html.twig', [
            'residents' => $residentsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_residents_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $resident = new Residents();
        $form = $this->createForm(ResidentsType::class, $resident);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($resident);
            $entityManager->flush();

            return $this->redirectToRoute('app_residents_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('residents/new.html.twig', [
            'resident' => $resident,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_residents_show', methods: ['GET'])]
    public function show(Residents $resident): Response
    {
        return $this->render('residents/show.html.twig', [
            'resident' => $resident,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_residents_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Residents $resident, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ResidentsType::class, $resident);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_residents_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('residents/edit.html.twig', [
            'resident' => $resident,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_residents_delete', methods: ['POST'])]
    public function delete(Request $request, Residents $resident, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resident->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($resident);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_residents_index', [], Response::HTTP_SEE_OTHER);
    }
}
