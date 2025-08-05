# Tests Pest - Backend Card Game

## 🧪 Structure des tests

```
tests/
├── Pest/
│   ├── CardTest.php                    # Tests de l'entité Card
│   ├── CardGameServiceTest.php         # Tests du service principal
│   ├── CardSortingServiceTest.php      # Tests du service de tri
│   ├── GameControllerTest.php          # Tests du contrôleur API
│   └── Feature/
│       └── GameApiTest.php             # Tests d'intégration API
└── bootstrap.php                       # Configuration PHPUnit
```

## 🚀 Exécution des tests

### Tests Pest uniquement
```bash
# Dans le conteneur backend
docker-compose exec backend ./run-pest-tests.sh

# Ou directement
docker-compose exec backend ./vendor/bin/pest
```

### Tests spécifiques
```bash
# Tests d'une classe spécifique
./vendor/bin/pest tests/Pest/CardTest.php

# Tests avec filtrage
./vendor/bin/pest --filter="Card"

# Tests avec couverture
./vendor/bin/pest --coverage
```

## 📋 Types de tests

### 1. Tests Unitaires (`tests/Pest/`)
- **CardTest.php** : Tests de l'entité Card
- **CardGameServiceTest.php** : Tests du service principal
- **CardSortingServiceTest.php** : Tests du service de tri
- **GameControllerTest.php** : Tests du contrôleur

### 2. Tests Feature (`tests/Pest/Feature/`)
- **GameApiTest.php** : Tests d'intégration des endpoints API

## 🎯 Avantages des tests Pest

### ✅ Syntaxe expressive
```php
// Pest (moderne)
it('should return success response', function () {
    expect($response)->toBeInstanceOf(JsonResponse::class);
    expect($response->getStatusCode())->toBe(201);
});

// PHPUnit (ancien)
public function testShouldReturnSuccessResponse(): void
{
    $this->assertInstanceOf(JsonResponse::class, $response);
    $this->assertEquals(201, $response->getStatusCode());
}
```

### ✅ Mocks intégrés
```php
$mockService = mock(CardGameServiceInterface::class);
$mockService->shouldReceive('createNewHand')->once()->andReturn($cards);
```

### ✅ Assertions fluides
```php
expect($result)->toHaveCount(10);
expect($data['success'])->toBeTrue();
expect($response)->toBeInstanceOf(JsonResponse::class);
```

## 🔧 Configuration

### Fichier `Pest.php`
- Configuration globale des tests
- Fonctions helpers globales
- Extensions d'assertions personnalisées

### Fonctions helpers
- `createMockCards(int $count)` : Crée des cartes mockées
- `createCardArrays(int $count)` : Crée des tableaux de cartes

## 🎯 Couverture de tests

### ✅ Entités
- Getters/Setters
- Méthodes métier
- Interface fluide

### ✅ Services
- Logique métier
- Gestion des erreurs
- Injection de dépendances

### ✅ Contrôleurs
- Réponses HTTP
- Gestion des exceptions
- Validation des données

### ✅ APIs
- Endpoints REST
- Formats de réponse
- Codes de statut

## 🚫 Tests sans base de données

Tous les tests utilisent des **mocks** au lieu de vraies connexions à la base de données :

- **Rapides** : Exécution en millisecondes
- **Fiables** : Pas de dépendances externes
- **Isolés** : Chaque test est indépendant
- **Prévisibles** : Résultats constants

## 📊 Exécution

```bash
# Tests complets
./run-pest-tests.sh

# Tests avec verbose
./vendor/bin/pest --verbose

# Tests avec couverture
./vendor/bin/pest --coverage --min=80
``` 