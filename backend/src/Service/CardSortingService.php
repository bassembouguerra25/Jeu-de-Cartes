<?php

namespace App\Service;

use App\Service\Interface\CardSortingServiceInterface;

class CardSortingService implements CardSortingServiceInterface
{
    /**
     * Trie les cartes par couleur puis par valeur
     */
    public function sortCards(array $cards): array
    {
        usort($cards, function($a, $b) {
            // D'abord par couleur
            if ($a['colorOrder'] !== $b['colorOrder']) {
                return $a['colorOrder'] - $b['colorOrder'];
            }
            // Puis par valeur
            return $a['valueOrder'] - $b['valueOrder'];
        });

        return $cards;
    }

    /**
     * Convertit les entités Card en tableaux pour l'API
     * (Méthode conservée pour compatibilité, mais les cartes sont déjà des tableaux)
     */
    public function convertCardsToArray(array $cards): array
    {
        // Les cartes sont déjà des tableaux, on les retourne telles quelles
        return $cards;
    }
} 