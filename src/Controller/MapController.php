<?php

namespace App\Controller;

use App\Repository\OTVRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{
    #[Route('/map', name: 'app_map')]
    public function index(OTVRepository $oTVRepository): Response
    {
        $OTVs = $oTVRepository->findAll();
        
        // Extract latitude and longitude from the data array
        $mappedOTVs = array_map(function ($otv) {
            return [
                'id' => $otv->getId(),
                'latitude' => $otv->getData()['latitude'] ?? null,
                'longitude' => $otv->getData()['longitude'] ?? null,
                'lastname' => $otv->getResidents()->getlastName(), 
                'firstname' => $otv->getResidents()->getfirstName(),
                'street' => $otv->getResidents()->getStreet(),
                'streetNumber' => $otv->getResidents()->getStreetNumber() ?? '',
                'additionnalStreetNumber' => $otv->getResidents()->getAdditionalStreetNumber() ?? '',
                'additionalAddressInfo' => $otv->getResidents()->getAdditionalAddressInfo() ?? '',
                'district' => $otv->getResidents()->getDistricts()->getName(),
            ];
        }, $OTVs);

        return $this->render('map/index.html.twig', [
            'OTVs' => $mappedOTVs,
        ]);
    }
}
