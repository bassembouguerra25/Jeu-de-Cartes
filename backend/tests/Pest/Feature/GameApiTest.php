<?php

use App\Service\Interface\CardGameServiceInterface;
use App\Service\Interface\CardSortingServiceInterface;
use App\Entity\Card;

describe('Game API Feature Tests', function () {
    
    beforeEach(function () {
        // Mock les services dans le container
        $this->mockCardGameService = mock(CardGameServiceInterface::class);
        $this->mockCardSortingService = mock(CardSortingServiceInterface::class);
        
        // Remplacer les services dans le container
        app()->instance(CardGameServiceInterface::class, $this->mockCardGameService);
        app()->instance(CardSortingServiceInterface::class, $this->mockCardSortingService);
    });

    it('should return successful response for POST /api/games/draw', function () {
        // Arrange
        $mockCards = createMockCards(10);
        $sortedCards = createMockCards(10);
        $convertedCards = createCardArrays(10);
        $convertedSortedCards = createCardArrays(10);

        $this->mockCardGameService
            ->shouldReceive('createNewHand')
            ->once()
            ->andReturn($mockCards);

        $this->mockCardSortingService
            ->shouldReceive('sortCards')
            ->once()
            ->andReturn($sortedCards);

        $this->mockCardSortingService
            ->shouldReceive('convertCardsToArray')
            ->twice()
            ->andReturn($convertedCards, $convertedSortedCards);

        // Act
        $response = $this->post('/api/games/draw');

        // Assert
        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'data' => [
                'cards' => $convertedCards,
                'sortedCards' => $convertedSortedCards
            ]
        ]);
    });

    it('should return rules for GET /api/games/rules', function () {
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
        $response = $this->get('/api/games/rules');

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'colors' => $expectedColors,
                'values' => $expectedValues,
                'handSize' => 10
            ]
        ]);
    });

    it('should handle database errors gracefully', function () {
        // Arrange
        $this->mockCardGameService
            ->shouldReceive('createNewHand')
            ->once()
            ->andThrow(new Exception('Database connection failed'));

        // Act
        $response = $this->post('/api/games/draw');

        // Assert
        $response->assertStatus(500);
        $response->assertJson([
            'success' => false
        ]);
        $response->assertJsonStructure([
            'success',
            'error'
        ]);
    });

    it('should return correct number of cards in response', function () {
        // Arrange
        $mockCards = createMockCards(10);
        $sortedCards = createMockCards(10);
        $convertedCards = createCardArrays(10);
        $convertedSortedCards = createCardArrays(10);

        $this->mockCardGameService
            ->shouldReceive('createNewHand')
            ->once()
            ->andReturn($mockCards);

        $this->mockCardSortingService
            ->shouldReceive('sortCards')
            ->once()
            ->andReturn($sortedCards);

        $this->mockCardSortingService
            ->shouldReceive('convertCardsToArray')
            ->twice()
            ->andReturn($convertedCards, $convertedSortedCards);

        // Act
        $response = $this->post('/api/games/draw');

        // Assert
        $data = $response->json('data');
        expect($data['cards'])->toHaveCount(10);
        expect($data['sortedCards'])->toHaveCount(10);
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