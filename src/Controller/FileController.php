<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends AbstractController
{
    #[Route('/file', name: 'app_file', methods: ['GET', 'POST'])]
    public function getFile(string $filename): Response
    {
        $projectDir = $this->getParameter('kernel.project_dir');
        $file = $projectDir . '/var/uploads/' . $filename;

        // Check if the file exists
        if (!file_exists($file)) {
            throw $this->createNotFoundException('The file does not exist.');
        }

        return new BinaryFileResponse($file);
    }
}