<?php

namespace App\Controller;

use App\Entity\OTV;
use App\Form\OtvType;
use App\DTO\OtvRequest;
use App\Entity\Address;
use App\Entity\Districts;
use App\Entity\Residents;
use App\Mapper\OtvMapper;
use Psr\Log\LoggerInterface;
use App\Mapper\AddressMapper;
use App\Services\FileUploader;
use App\Services\PdfGenerator;
use App\Mapper\ResidentsMapper;
use App\Mapper\OTVRequestMapper;
use App\Repository\OTVRepository;
use App\Services\OTVStatusUpdater;
use App\Repository\AddressRepository;
use App\Security\ApiKeyAuthenticator;
use App\Repository\DistrictsRepository;
use App\Repository\ResidentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/otv')]
class OTVController extends AbstractController
{
    private $uploadsDirectory;
    private $apiKeyAuthenticator;
    private Security $security;
    private OTVStatusUpdater $otvStatusUpdater;
    private LoggerInterface $logger;

    public function __construct(
        Security $security,
        string $uploadsDirectory,
        ApiKeyAuthenticator $apiKeyAuthenticator,
        OTVStatusUpdater $otvStatusUpdater,
        LoggerInterface $logger
    ) {
        $this->uploadsDirectory = $uploadsDirectory;
        $this->apiKeyAuthenticator = $apiKeyAuthenticator;
        $this->security = $security;
        $this->otvStatusUpdater = $otvStatusUpdater;
        $this->logger = $logger;
    }

    #[Route('/', name: 'app_otv_index', methods: ['GET'])]
    public function index(OTVRepository $oTVRepository, DistrictsRepository $districtsRepository): Response
    {

        $currentUser = $this->security->getUser();
        // Vérifier si l'utilisateur est bien connecté
        if (!$currentUser) {
            $this->addFlash('error',  "Vous devez être connecté pour accéder à cette page");
            return $this->redirectToRoute('app_login');
        }

        $OTVs = $oTVRepository->findAll();
        $districts = $districtsRepository->findAll();

        // Mettre à jour le statut de tous les OTVs à l'affichage de l'index
        foreach ($OTVs as $otv) {
            $this->otvStatusUpdater->updateStatus($otv);
        }

        return $this->render('otv/index.html.twig', [
            'OTVs' => $OTVs,
            'districts' => $districts,
        ]);
    }


    #[Route('/notice', name: 'app_otv_notice_pdf', methods: ['GET'])]
    public function noticePdf(OTVRepository $oTVRepository, DistrictsRepository $districtsRepository, PdfGenerator $pdfGenerator): Response
    {
        $districts = $districtsRepository->findAll();
        $OTVsByDistrict = [];

        foreach ($districts as $district) {
            $OTVs = $oTVRepository->findBy(['status' => 'ongoing', 'district' => $district]);
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
    public function new(
        AddressMapper $addressMapper,
        ResidentsMapper $residentsMapper,
        AddressRepository $addressRepository,
        ResidentsRepository $residentsRepository,
        FileUploader $fileUploader,
        
        Request $request,
        EntityManagerInterface $entityManager,
        OTVRequestMapper $OTVRequestMapper,
        DistrictsRepository $districtsRepository
    ): Response {
        if (!$this->apiKeyAuthenticator->authenticate($request)) {
            $this->logger->info('Unauthorized request');
            return new JsonResponse(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        // Récupérer toutes les données du formulaire
        $formData = $request->request->all();
        $data = $formData['data'];
        $this->logger->info('Data received: ' . json_encode($data));

        // Vérifier si le résident existe déjà
        $existingResident = $residentsRepository->findOneBy([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
        ]);
        if ($existingResident) {
            // Le résident existe déjà, utilisez-le pour la suite du traitement
            $resident = $existingResident;
        } else {
            // Le résident n'existe pas, créez une nouvelle entité
            $resident = new Residents();
            $resident = $residentsMapper->mapToEntity($resident, $data);
            $this->logger->info('New resident created: ' . json_encode($resident));
        }

        // Vérifier si l'adresse existe déjà
        $existingAddress = $addressRepository->findOneBy([
            'street' => $data['street'],
            'streetNumber' => $data['streetNumber'],
            'additionnalStreetNumber' => $data['additionalStreetNumber'] ?? null,
            'additionalAddressInfo' => $data['additionalAddressInfo'] ?? null,
        ]);
        if ($existingAddress) {
            // L'adresse existe déjà, utilisez-le pour la suite du traitement
            $address = $existingAddress;
        } else {
            // Le résident n'existe pas, créez une nouvelle entité
            $address = new Address();
            $address = $addressMapper->mapToEntity($address, $data);
            $this->logger->info('New address created: ' . json_encode($address));
        }

        // Vérifier si le quartier existe déjà
        $existingDistrict = $districtsRepository->findOneBy([
            'name' => $data['district'],
        ]);
        if ($existingDistrict) {
            $district = $existingDistrict;
        } else {
            $district = new Districts();
            $district = $district->setName($data['district']);
            $this->logger->info('New district created: ' . json_encode($address));
        }

        // Créer l'entité OTV
        $OTV = new OTV();
        $OTV = $OTVRequestMapper->mapToEntity($OTV, $data);
        $OTV->setResidents($resident);
        $OTV->setAddress($address);
        $OTV->setDistrict($district);
        $this->logger->info('New OTV created: ' . json_encode($OTV));

        // Gérer le fichier uploadé
        /** @var UploadedFile $file **/
        $file = $request->files->get('file');
        if ($file) {
            $this->logger->info('File received: ' . $file->getClientOriginalName());
            try {
                $this->logger->info('Starting file upload...');
                $newFilename = $fileUploader->uploadFile($file, $data['lastname'], $data['firstname']);
                $this->logger->info('File upload successful, new filename: ' . $newFilename);
                $OTV->setFileName($newFilename);
                $OTV->setPathToFile($this->uploadsDirectory . '/' . $newFilename);
                $this->logger->info('File path set on OTV');
            } catch (\Exception $e) {
                $this->logger->error('File upload error: ' . $e->getMessage());
                return new JsonResponse(['error' => 'File upload failed: ' . $e->getMessage()], 500);
            }
        } else {
            $this->logger->info('No file received');
        }

        // Persister les entités

        $entityManager->persist($resident);
        $entityManager->persist($address);
        $entityManager->persist($OTV);
        $this->logger->info('Entities persisted');

        // Flush les entités
        try {
            $entityManager->flush();
            $this->logger->info('Entities flushed');
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        // Retourner une réponse OK si tout se passe bien
        return new JsonResponse(['status' => 'OK'], 200);
    }


    #[Route('/{id}', name: 'app_otv_show', methods: ['GET'])]
    public function show(OTV $otv, OTVRepository $OTVRepository): Response
    {

        $currentUser = $this->security->getUser();
        // Vérifier si l'utilisateur est bien connecté
        if (!$currentUser) {
            $this->addFlash('error',  "Vous devez être connecté pour accéder à cette page");
            return $this->redirectToRoute('home');
        }

        return $this->render('otv/show.html.twig', [
            'otv' => $otv,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_otv_edit', methods: ['POST', 'GET'])]
    public function edit(Request $request, OTV $OTV, OtvMapper $OtvMapper, OtvRequest $OtvRequest, EntityManagerInterface $entityManager): Response
    {

        $currentUser = $this->security->getUser();
        // Vérifier si l'utilisateur est bien connecté
        if (!$currentUser) {
            $this->addFlash('error',  "Vous devez être connecté pour accéder à cette page");
            return $this->redirectToRoute('app_login');
        }

        // Créer un objet OtvRequest à partir des données de l'objet OTV
        $OtvRequest = new OtvRequest();
        $OtvMapper->mapToOtvRequest($OTV, $OtvRequest);

        $form = $this->createForm(OtvType::class, $OtvRequest);
        $form->handleRequest($request);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $OtvRequest = $form->getData();

                $OtvMapper->mapToOtv($OTV, $OtvRequest);

                $entityManager->flush();

                $this->addFlash(
                'success',
                'Vos modifications ont été enregistrées avec succès !'
                );
                return $this->redirectToRoute('app_otv_index', [], Response::HTTP_SEE_OTHER);
            }
        } catch (\Exception $e) {
            $this->logger->error('Error while editing OTV: ' . $e->getMessage());
            $this->addFlash(
            'error',
            'Une erreur est survenue lors de la modification de l\'OTV'
            );
        }

        return $this->render('otv/edit.html.twig', [
            'otv' => $OTV,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_otv_delete', methods: ['POST'])]
    public function delete(Request $request, OTV $oTV, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->security->getUser();
        // Vérifier si l'utilisateur est bien connecté
        if (!$currentUser) {
            $this->addFlash('error',  "Vous devez être connecté pour accéder à cette page");
            return $this->redirectToRoute('app_login');
        }

        if ($this->isCsrfTokenValid('delete' . $oTV->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($oTV);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_otv_index', [], Response::HTTP_SEE_OTHER);
    }
}
