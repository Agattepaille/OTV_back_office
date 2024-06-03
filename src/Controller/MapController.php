<?php

namespace App\Controller;

use App\Repository\DistrictsRepository;
use App\Repository\OTVRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/map', name: 'app_map')]
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
        
        // Extract latitude and longitude from the data array
        $mappedOTVs = array_map(function ($otv) {
            return [
                'id' => $otv->getId(),
                'latitude' => $otv->getData()['latitude'] ?? null,
                'longitude' => $otv->getData()['longitude'] ?? null,
                'lastname' => $otv->getResidents()->getlastName(), 
                'firstname' => $otv->getResidents()->getfirstName(),
                'street' => $otv->getAddress()->getStreet(),
                'streetNumber' => $otv->getAddress()->getStreetNumber() ?? '',
                'additionnalStreetNumber' => $otv->getAddress()->getAdditionnalStreetNumber() ?? '',
                'additionalAddressInfo' => $otv->getAddress()->getAdditionalAddressInfo() ?? '',
                'district' => $otv->getDistrict()->getName(),
            ];
        }, $OTVs);

        return $this->render('map/index.html.twig', [
            'OTVs' => $mappedOTVs,
            'districts' => $districts,
        ]);
    }
}
