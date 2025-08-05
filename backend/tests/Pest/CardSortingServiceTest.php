<?php

use App\Service\CardSortingService;

describe('CardSortingService', function () {
    
    beforeEach(function () {
        $this->cardSortingService = new CardSortingService();
    });

    it('should sort cards by color and value correctly', function () {
        // Arrange
        $cards = [
            $this->createCard('Pique', 'AS', 2, 0),
            $this->createCard('Carreaux', 'Roi', 0, 12),
            $this->createCard('Cœur', 'Valet', 1, 10),
            $this->createCard('Carreaux', 'AS', 0, 0),
        ];

        // Act
        $sortedCards = $this->cardSortingService->sortCards($cards);

        // Assert
        expect($sortedCards)->toHaveCount(4);
        
        // Vérifier l'ordre : Carreaux AS, Carreaux Roi, Cœur Valet, Pique AS
        expect($sortedCards[0]['color'])->toBe('Carreaux');
        expect($sortedCards[0]['value'])->toBe('AS');
        
        expect($sortedCards[1]['color'])->toBe('Carreaux');
        expect($sortedCards[1]['value'])->toBe('Roi');
        
        expect($sortedCards[2]['color'])->toBe('Cœur');
        expect($sortedCards[2]['value'])->toBe('Valet');
        
        expect($sortedCards[3]['color'])->toBe('Pique');
        expect($sortedCards[3]['value'])->toBe('AS');
    });

    it('should convert cards to array correctly', function () {
        // Arrange
        $cards = [
            $this->createCard('Carreaux', 'AS', 0, 0),
            $this->createCard('Cœur', 'Roi', 1, 12),
        ];

        // Act
        $result = $this->cardSortingService->convertCardsToArray($cards);

        // Assert
        expect($result)->toHaveCount(2);
        expect($result[0])->toBeArray();
        expect($result[0]['id'])->toBe(1);
        expect($result[0]['color'])->toBe('Carreaux');
        expect($result[0]['value'])->toBe('AS');
        expect($result[0]['displayName'])->toBe('AS de Carreaux');
    });

    it('should return empty array for empty input', function () {
        // Act
        $result = $this->cardSortingService->sortCards([]);

        // Assert
        expect($result)->toBeArray();
        expect($result)->toBeEmpty();
    });

    it('should handle single card correctly', function () {
        // Arrange
        $cards = [$this->createCard('Carreaux', 'AS', 0, 0)];

        // Act
        $result = $this->cardSortingService->sortCards($cards);

        // Assert
        expect($result)->toHaveCount(1);
        expect($result[0]['color'])->toBe('Carreaux');
        expect($result[0]['value'])->toBe('AS');
    });
});

// Helper function
function createCard(string $color, string $value, int $colorOrder, int $valueOrder): array
{
    return [
        'id' => $colorOrder * 13 + $valueOrder + 1,
        'color' => $color,
        'value' => $value,
        'colorOrder' => $colorOrder,
        'valueOrder' => $valueOrder,
        'displayName' => $value . ' de ' . $color
    ];
} 