<?php

namespace App\Controller;

use App\Entity\OTV;
use App\Services\PdfGenerator;
use App\Repository\OTVRepository;
use App\Repository\DistrictsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/file')]
class FileController extends AbstractController
{
  #[Route('/', name: 'app_file', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('file/index.html.twig', [
            'controller_name' => 'FileController',
        ]);
    } 

    #[Route('/{id}', name: 'app_file', methods: ['GET'])]
    public function show(OTV $otv): Response
    {
        $filePath = $otv->getPathToFile();

        // Vérifiez si le fichier existe
        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('Le fichier demandé n\'existe pas.');
        }

        // Retournez le fichier en tant que réponse HTTP
        return new BinaryFileResponse($filePath);
    }
    
}

