<?php

use App\Controller\Api\GameController;
use App\Service\Interface\CardGameServiceInterface;
use App\Service\Interface\CardSortingServiceInterface;
use App\Entity\Card;
use Symfony\Component\HttpFoundation\JsonResponse;

beforeEach(function () {
    $this->mockCardGameService = mock(CardGameServiceInterface::class);
    $this->mockCardSortingService = mock(CardSortingServiceInterface::class);
    
    $this->gameController = new GameController(
        $this->mockCardGameService,
        $this->mockCardSortingService
    );
});

describe('GameController API Tests', function () {
    
    it('should return success response when drawing cards', function () {
        // Arrange
        $mockCards = $this->createMockCards(10);
        $sortedCards = $this->createMockCards(10);
        $convertedCards = $this->createCardArrays(10);
        $convertedSortedCards = $this->createCardArrays(10);

        $this->mockCardGameService
            ->shouldReceive('createNewHand')
            ->once()
            ->andReturn($mockCards);

        $this->mockCardSortingService
            ->shouldReceive('sortCards')
            ->once()
            ->with($mockCards)
            ->andReturn($sortedCards);

        $this->mockCardSortingService
            ->shouldReceive('convertCardsToArray')
            ->twice()
            ->andReturn($convertedCards, $convertedSortedCards);

        // Act
        $response = $this->gameController->drawCards();

        // Assert
        expect($response)->toBeInstanceOf(JsonResponse::class);
        expect($response->getStatusCode())->toBe(201);
        
        $data = json_decode($response->getContent(), true);
        expect($data['success'])->toBeTrue();
        expect($data['data'])->toHaveKey('cards');
        expect($data['data'])->toHaveKey('sortedCards');
        expect($data['data']['cards'])->toHaveCount(10);
        expect($data['data']['sortedCards'])->toHaveCount(10);
    });

    it('should handle exceptions when drawing cards', function () {
        // Arrange
        $this->mockCardGameService
            ->shouldReceive('createNewHand')
            ->once()
            ->andThrow(new Exception('Database error'));

        // Act
        $response = $this->gameController->drawCards();

        // Assert
        expect($response)->toBeInstanceOf(JsonResponse::class);
        expect($response->getStatusCode())->toBe(500);
        
        $data = json_decode($response->getContent(), true);
        expect($data['success'])->toBeFalse();
        expect($data['error'])->toContain('Erreur lors du tirage des cartes');
    });

    it('should return correct rules data', function () {
        // Arrange
        $expectedColors = ['Carreaux', 'Cœur', 'Pique', 'Trèfle'];
        $expectedValues = ['AS', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Valet', 'Dame', 'Roi'];
        
        $this->mockCardGameService
            ->shouldReceive('getColors')
            ->once()
            ->andReturn($expectedColors);

        $this->mockCardGameService
            ->shouldReceive('getValues')
            ->once()
            ->andReturn($expectedValues);

        // Act
        $response = $this->gameController->getRules();

        // Assert
        expect($response)->toBeInstanceOf(JsonResponse::class);
        expect($response->getStatusCode())->toBe(200);
        
        $data = json_decode($response->getContent(), true);
        expect($data['success'])->toBeTrue();
        expect($data['data']['colors'])->toBe($expectedColors);
        expect($data['data']['values'])->toBe($expectedValues);
        expect($data['data']['handSize'])->toBe(10);
    });
});

// Helper functions
function createMockCards(int $count): array
{
    $cards = [];
    for ($i = 0; $i < $count; $i++) {
        $card = mock(Card::class);
        $card->shouldReceive('getId')->andReturn($i + 1);
        $card->shouldReceive('getColor')->andReturn('Carreaux');
        $card->shouldReceive('getValue')->andReturn('AS');
        $card->shouldReceive('getDisplayName')->andReturn('AS de Carreaux');
        $cards[] = $card;
    }
    return $cards;
}

function createCardArrays(int $count): array
{
    $cards = [];
    for ($i = 0; $i < $count; $i++) {
        $cards[] = [
            'id' => $i + 1,
            'color' => 'Carreaux',
            'value' => 'AS',
            'displayName' => 'AS de Carreaux'
        ];
    }
    return $cards;
} 