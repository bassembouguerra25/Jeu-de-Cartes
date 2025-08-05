<?php

namespace App\Service;

use App\Service\Interface\CardGameServiceInterface;

class CardGameService implements CardGameServiceInterface
{
    private const HAND_SIZE = 10;

    /**
     * Crée une nouvelle main de 10 cartes aléatoires
     */
    public function createNewHand(): array
    {
        $allCards = $this->generateAllCards();
        shuffle($allCards);
        return array_slice($allCards, 0, self::HAND_SIZE);
    }

    /**
     * Génère toutes les cartes du jeu en mémoire
     */
    private function generateAllCards(): array
    {
        $cards = [];
        $colors = ['Carreaux', 'Cœur', 'Pique', 'Trèfle'];
        $values = ['AS', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Valet', 'Dame', 'Roi'];

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

    /**
     * Retourne les couleurs dans l'ordre
     */
    public function getColors(): array
    {
        return ['Carreaux', 'Cœur', 'Pique', 'Trèfle'];
    }

    /**
     * Retourne les valeurs dans l'ordre
     */
    public function getValues(): array
    {
        return ['AS', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Valet', 'Dame', 'Roi'];
    }
} 