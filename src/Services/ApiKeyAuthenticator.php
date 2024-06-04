<?php

namespace App\Services;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

class ApiKeyAuthenticator
{
    private $apiKey;
    public $logger;

    public function __construct(string $apiKey, LoggerInterface $logger)
    {
        $this->apiKey = $apiKey;
        $this->logger = $logger;
    }

    public function authenticate(Request $request): bool
    {
        // Récupérer la clé API de la requête
        $authorizationHeader = $request->headers->get('Authorization');
        $this->logger->info('Authorization header: '.$authorizationHeader);
        if (!$authorizationHeader) {
            return false;
        }

        // Extraire la clé API du header
        list($type, $providedApiKey) = explode(' ', $authorizationHeader, 2);
        if (strtolower($type) !== 'bearer') {
            return false;
        }

        // Comparer avec la clé API stockée
        return hash_equals($this->apiKey, $providedApiKey);
    }
}
