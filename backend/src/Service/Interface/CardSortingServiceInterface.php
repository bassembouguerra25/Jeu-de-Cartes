<?php

namespace App\Service\Interface;

interface CardSortingServiceInterface
{
    /**
     * Trie les cartes par couleur puis par valeur
     */
    public function sortCards(array $cards): array;

    /**
     * Convertit les entités Card en tableaux pour l'API
     */
    public function convertCardsToArray(array $cards): array;
} 