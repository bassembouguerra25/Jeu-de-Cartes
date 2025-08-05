<?php

namespace App\Controller\Api;

use App\Service\Interface\CardGameServiceInterface;
use App\Service\Interface\CardSortingServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/games', name: 'api_games_')]
class GameController extends AbstractController
{
    public function __construct(
        private CardGameServiceInterface $cardGameService,
        private CardSortingServiceInterface $cardSortingService
    ) {
    }

    #[Route('/draw', name: 'draw', methods: ['POST'])]
    public function drawCards(): JsonResponse
    {
        try {
            $cards = $this->cardGameService->createNewHand();
            
            $data = [
                'cards' => $cards,
                'sortedCards' => $this->cardSortingService->sortCards($cards)
            ];

            $response = $this->json([
                'success' => true,
                'data' => $data
            ], 201);

            // Ajouter les headers CORS
            $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, Accept, Origin, X-Requested-With');

            return $response;
        } catch (\Exception $e) {
            $response = $this->json([
                'success' => false,
                'error' => 'Erreur lors du tirage des cartes: ' . $e->getMessage()
            ], 500);

            // Ajouter les headers CORS
            $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, Accept, Origin, X-Requested-With');

            return $response;
        }
    }

    #[Route('/rules', name: 'rules', methods: ['GET'])]
    public function getRules(): JsonResponse
    {
        $response = $this->json([
            'success' => true,
            'data' => [
                'colors' => $this->cardGameService->getColors(),
                'values' => $this->cardGameService->getValues(),
                'handSize' => 10
            ]
        ]);

        // Ajouter les headers CORS
        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, Accept, Origin, X-Requested-With');

        return $response;
    }
} 