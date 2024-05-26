<?php

namespace App\Services;

use App\Kernel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileUploader
{
    private $uploadsDirectory;
    private $logger;

    public function __construct(string $uploadsDirectory, LoggerInterface $logger)
    {
        $this->uploadsDirectory = $uploadsDirectory;
        $this->logger = $logger;
    }

    public function uploadFile(UploadedFile $file, string $lastname, string $firstname): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $lastname = $this->removeAccents($lastname);
        $firstname = $this->removeAccents($firstname);
        $newFilename = uniqid() . '_' . $lastname . '_' . $firstname . '.' . $file->guessExtension();
        $storage = $this->uploadsDirectory;

        // Déplacer le fichier vers le répertoire de stockage
        try {
            $file->move(
                $storage,
                $newFilename
            );
        } catch (FileException $e) {
            $this->logger->error('File upload error: ' . $e->getMessage());
            throw new \Exception('File upload error: ' . $e->getMessage());
        }

        return $newFilename;
    }

    private function removeAccents($string): string
    {
        if (!extension_loaded('intl')) {
            throw new \Exception('The intl extension is not loaded.');
        }

        $normalized = \Normalizer::normalize($string, \Normalizer::FORM_D);
        return preg_replace('/[\x{0300}-\x{036f}]/u', '', $normalized);
    }
}
