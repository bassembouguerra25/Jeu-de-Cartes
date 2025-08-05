<?php

namespace App\Service\Interface;

interface CardGameServiceInterface
{
    /**
     * Crée une nouvelle main de cartes aléatoires
     */
    public function createNewHand(): array;

    /**
     * Retourne les couleurs dans l'ordre
     */
    public function getColors(): array;

    /**
     * Retourne les valeurs dans l'ordre
     */
    public function getValues(): array;
} 