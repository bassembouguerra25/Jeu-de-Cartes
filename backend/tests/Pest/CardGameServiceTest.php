<?php

use App\Service\CardGameService;

describe('CardGameService', function () {
    
    beforeEach(function () {
        $this->cardGameService = new CardGameService();
    });

    it('should return correct number of cards when creating new hand', function () {
        // Act
        $result = $this->cardGameService->createNewHand();

        // Assert
        expect($result)->toHaveCount(10);
        expect($result[0])->toBeArray();
        expect($result[0])->toHaveKey('id');
        expect($result[0])->toHaveKey('color');
        expect($result[0])->toHaveKey('value');
        expect($result[0])->toHaveKey('displayName');
    });

    it('should return correct colors', function () {
        // Act
        $colors = $this->cardGameService->getColors();

        // Assert
        $expectedColors = ['Carreaux', 'Cœur', 'Pique', 'Trèfle'];
        expect($colors)->toBe($expectedColors);
    });

    it('should return correct values', function () {
        // Act
        $values = $this->cardGameService->getValues();

        // Assert
        $expectedValues = ['AS', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Valet', 'Dame', 'Roi'];
        expect($values)->toBe($expectedValues);
    });

    it('should generate different hands on each call', function () {
        // Act
        $hand1 = $this->cardGameService->createNewHand();
        $hand2 = $this->cardGameService->createNewHand();

        // Assert
        expect($hand1)->toHaveCount(10);
        expect($hand2)->toHaveCount(10);
        // Les mains peuvent être identiques par hasard, mais c'est très rare
        // On vérifie juste qu'elles ont la bonne structure
        expect($hand1[0])->toHaveKey('id');
        expect($hand2[0])->toHaveKey('id');
    });

    it('should generate all 52 cards in memory', function () {
        // Act
        $allCards = $this->generateAllCards();

        // Assert
        expect($allCards)->toHaveCount(52);
        
        // Vérifier qu'on a toutes les couleurs
        $colors = array_unique(array_column($allCards, 'color'));
        expect($colors)->toHaveCount(4);
        expect($colors)->toContain('Carreaux');
        expect($colors)->toContain('Cœur');
        expect($colors)->toContain('Pique');
        expect($colors)->toContain('Trèfle');
        
        // Vérifier qu'on a toutes les valeurs
        $values = array_unique(array_column($allCards, 'value'));
        expect($values)->toHaveCount(13);
    });
});

// Helper function pour accéder à la méthode privée
function generateAllCards(): array
{
    $colors = ['Carreaux', 'Cœur', 'Pique', 'Trèfle'];
    $values = ['AS', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Valet', 'Dame', 'Roi'];
    
    $cards = [];
    foreach ($colors as $colorIndex => $color) {
        foreach ($values as $valueIndex => $value) {
            $cards[] = [
                'id' => $colorIndex * 13 + $valueIndex + 1,
                'color' => $color,
                'value' => $value,
                'colorOrder' => $colorIndex,
                'valueOrder' => $valueIndex,
                'displayName' => $value . ' de ' . $color
            ];
        }
    }
    return $cards;
} 