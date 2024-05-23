<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\OTV;
use Monolog\Logger;
use App\Form\OTVType;
use App\Entity\Residents;
use Psr\Log\LoggerInterface;
use App\Services\FileUploader;
use App\Services\PdfGenerator;
use App\Mapper\ResidentsMapper;
use App\Mapper\OTVRequestMapper;
use App\Repository\OTVRepository;
use App\Repository\DistrictsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/otv')]
class OTVController extends AbstractController
{
    private $uploadsDirectory;

    public function __construct(string $uploadsDirectory)
    {
        $this->uploadsDirectory = $uploadsDirectory;
    }

    #[Route('/', name: 'app_otv_index', methods: ['GET'])]
    public function index(OTVRepository $oTVRepository, DistrictsRepository $districtsRepository): Response
    {
        $OTVs = $oTVRepository->findAll();
        $districts = $districtsRepository->findAll();

        return $this->render('otv/index.html.twig', [
            'OTVs' => $OTVs,
            'districts' => $districts
        ]);
    }


    #[Route('/notice', name: 'app_otv_notice_pdf', methods: ['GET'])]
    public function noticePdf(OTVRepository $oTVRepository, DistrictsRepository $districtsRepository, PdfGenerator $pdfGenerator): Response
    {
        $districts = $districtsRepository->findAll();
        $OTVsByDistrict = [];

        foreach ($districts as $district) {
            $OTVs = $oTVRepository->findByStatusAndDistrict(true, $district->getName());
            if (!empty($OTVs)) {
                $OTVsByDistrict[$district->getName()] = $OTVs;
            }
        }

        $logoPolice = $pdfGenerator->imageToBase64($this->getParameter('kernel.project_dir') . '/public/assets/images/Logo_Police_Municipale__France_.webp');
        $html = $this->renderView('documents/noticePdf.html.twig', [
            'OTVsByDistrict' => $OTVsByDistrict,
            'logoPolice' => $logoPolice
        ]);


        $pdfContent = $pdfGenerator->generatePdf($html);

        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="avis_de_passage.pdf"',
        ]);
    }


    #[Route('/new', name: 'app_otv_new', methods: ['GET', 'POST'])]
    public function new(FileUploader $fileUploader, LoggerInterface $logger, Request $request, EntityManagerInterface $entityManager, OTVRequestMapper $OTVRequestMapper, ResidentsMapper $residentsMapper, DistrictsRepository $districtsRepository): Response
    {
        // Récupérer toutes les données du formulaire
        $formData = $request->request->all();
        $logger->info('Received data: ' . json_encode($formData));

        // Créer l'entité Residents
        $resident = new Residents();
        $resident = $residentsMapper->mapToEntity($resident, $formData);

        // Get the district id for the selected district
        $district = $districtsRepository->findOneByName($formData['district']);

        // Set the district on the resident
        $resident->setDistricts($district);

        // Créer l'entité OTV
        $OTV = new OTV();
        $OTV = $OTVRequestMapper->mapToEntity($OTV, $formData);
        $OTV->setResidents($resident);

        // Gérer le fichier uploadé
        /** @var UploadedFile $file **/
        $file = $request->files->get('file');
        if ($file) {
            try {
                $newFilename = $fileUploader->uploadFile($file, $formData['lastname'], $formData['firstname']);
                $OTV->setFileName($newFilename);
                $OTV->setPathToFile($this->uploadsDirectory . '/' . $newFilename);
            } catch (\Exception $e) {
                return new JsonResponse(['error' => $e->getMessage()], 500);
            }
        }

        // Persister les entités
        $entityManager->persist($resident);
        $entityManager->persist($OTV);

        // Flush les entités
        try {
            $entityManager->flush();
        } catch (\Exception $e) {
            $logger->error($e->getMessage());
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        // Retourner une réponse OK si tout se passe bien
        return new JsonResponse(['status' => 'OK'], 200);
    }


    #[Route('/{id}', name: 'app_otv_show', methods: ['GET'])]
    public function show(OTV $otv, OTVRepository $OTVRepository): Response
    {
        $renamedData = $OTVRepository->getRenamedData($otv);

        return $this->render('otv/show.html.twig', [
            'otv' => $otv,
            'data' => $renamedData,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_otv_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OTV $oTV, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OTVType::class, $oTV);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_otv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('otv/edit.html.twig', [
            'otv' => $oTV,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_otv_delete', methods: ['POST'])]
    public function delete(Request $request, OTV $oTV, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $oTV->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($oTV);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_otv_index', [], Response::HTTP_SEE_OTHER);
    }
}
