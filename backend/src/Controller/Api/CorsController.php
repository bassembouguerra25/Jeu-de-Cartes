<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CorsController extends AbstractController
{
    #[Route('/api/{path}', name: 'api_cors_preflight', methods: ['OPTIONS'], requirements: ['path' => '.*'])]
    public function handlePreflight(): Response
    {
        $response = new Response();
        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, Accept, Origin, X-Requested-With');
        $response->headers->set('Access-Control-Max-Age', '3600');
        
        return $response;
    }
} 