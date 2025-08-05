# 🎴 Jeu de Cartes - Application Complète

Une application de jeu de cartes moderne développée avec Symfony 6 (API) et Vue.js 3 (Frontend), entièrement dockerisée avec une architecture SOLID, des tests Pest, et une interface utilisateur élégante.

## 🎯 Fonctionnalités

- **🎲 Tirage aléatoire** : Tire une main de 10 cartes aléatoires en mémoire
- **✅ Tri automatique** : Affiche les cartes triées par couleur et valeur
- **🎨 Interface moderne** : Design élégant avec animations et effets visuels
- **🏗️ Architecture SOLID** : Backend respectant les principes SOLID
- **🧪 Tests Pest** : Suite de tests moderne avec Pest
- **📚 Documentation** : API documentée avec Swagger/OpenAPI

## 🏗️ Architecture

### Backend (Symfony 6)
- **Framework** : Symfony 6.3 avec architecture SOLID
- **Génération de cartes** : En mémoire (pas de base de données)
- **API Documentation** : Swagger/OpenAPI 3.0
- **Tests** : Pest (framework de test moderne)
- **Architecture** : Services avec interfaces, injection de dépendances

### Frontend (Vue.js 3)
- **Framework** : Vue.js 3 avec Composition API
- **Build Tool** : Vite
- **State Management** : Pinia
- **Routing** : Vue Router 4
- **Styling** : Tailwind CSS avec design moderne
- **Animations** : Effets de survol et transitions fluides

### Infrastructure
- **Containerisation** : Docker & Docker Compose
- **Serveur web** : Nginx (production)

## 🚀 Installation et Démarrage

### Prérequis
- Docker et Docker Compose
- Git

### 1. Cloner le projet
```bash
git clone <repository-url>
cd cardgame
```

### 2. Lancer l'application
```bash
# Méthode 1 : Script de démarrage automatique (recommandé)
./start.sh

# Méthode 2 : Docker Compose manuel
docker-compose up --build

# Ou en arrière-plan
docker-compose up -d --build
```

### 3. Accéder à l'application
- **Frontend** : http://localhost:3000
- **Backend API** : http://localhost:8000
- **Documentation Swagger** : http://localhost:8000/api/doc

## 📁 Structure du Projet

```
cardgame/
├── backend/                 # Application Symfony
│   ├── src/
│   │   ├── Controller/     # Contrôleurs API
│   │   ├── Service/        # Services métier (SOLID)
│   │   │   └── Interface/  # Interfaces pour injection
│   │   └── tests/          # Tests Pest
│   │       └── Pest/       # Tests unitaires et feature
│   ├── config/             # Configuration Symfony
│   └── Dockerfile          # Image Docker backend
├── frontend/               # Application Vue.js
│   ├── src/
│   │   ├── components/     # Composants Vue (design moderne)
│   │   ├── views/          # Pages Vue
│   │   ├── stores/         # Stores Pinia
│   │   └── router/         # Configuration router
│   └── Dockerfile          # Image Docker frontend
├── nginx/                  # Configuration Nginx
├── docker-compose.yml      # Orchestration Docker
├── start.sh               # Script de démarrage automatique
└── README.md              # Documentation
```

## 🎮 Utilisation

### Créer une nouvelle partie
1. Accédez à l'application via http://localhost:3000
2. Cliquez sur "🎲 Tirer une nouvelle main"
3. L'application tire 10 cartes aléatoires en mémoire
4. Visualisez la main non triée puis triée avec un design élégant

## 📊 API Documentation

### Endpoints disponibles

#### POST /api/games/draw
Tire une main de 10 cartes aléatoires en mémoire et les retourne triées.

**Réponse :**
```json
{
  "success": true,
  "data": {
    "cards": [
      {
        "id": 1,
        "color": "Carreaux",
        "value": "AS",
        "displayName": "AS de Carreaux"
      }
    ],
    "sortedCards": [...]
  }
}
```

#### GET /api/games/rules
Récupère les règles du jeu (couleurs et valeurs).

**Réponse :**
```json
{
  "success": true,
  "data": {
    "colors": ["Carreaux", "Cœur", "Pique", "Trèfle"],
    "values": ["AS", "2", "3", "4", "5", "6", "7", "8", "9", "10", "Valet", "Dame", "Roi"],
    "handSize": 10
  }
}
```

### Documentation Swagger
- **Interface Swagger UI** : http://localhost:8000/api/doc
- **Documentation JSON** : http://localhost:8000/api/doc.json

## 🎨 Design et Interface

### Cartes modernes
- **Design élégant** : Bordures arrondies, ombres en profondeur
- **Effets visuels** : Animations de survol, effets de brillance
- **Couleurs distinctes** : Rouge pour Cœur/Carreaux, noir pour Pique/Trèfle
- **Responsive** : Adaptation automatique sur tous les écrans

### Animations
- **Hover effects** : Scale et ombres au survol
- **Transitions fluides** : Durées optimisées pour l'UX
- **Tooltips** : Informations détaillées au survol

## 🏗️ Architecture SOLID

### Principes respectés
- **Single Responsibility** : Chaque classe a une seule responsabilité
- **Open/Closed** : Extensible sans modification
- **Liskov Substitution** : Interfaces respectées
- **Interface Segregation** : Interfaces spécifiques
- **Dependency Inversion** : Dépendance des abstractions

### Services
- **CardGameService** : Logique métier du jeu
- **CardSortingService** : Tri des cartes
- **Interfaces** : Injection de dépendances

## 🧪 Tests Pest

### Structure des tests
```
tests/Pest/
├── CardTest.php              # Tests de l'entité Card
├── CardGameServiceTest.php   # Tests du service principal
├── CardSortingServiceTest.php # Tests du service de tri
├── GameControllerTest.php    # Tests du contrôleur
└── Feature/
    └── GameApiTest.php       # Tests d'intégration API
```

### Exécution des tests
```bash
# Tests Pest
docker-compose exec backend ./run-pest-tests.sh

# Tests avec couverture
docker-compose exec backend ./vendor/bin/pest --coverage
```

### Avantages Pest
- **Syntaxe expressive** : `it('should work', function () {})`
- **Mocks intégrés** : `mock(Service::class)`
- **Assertions fluides** : `expect($result)->toBe(true)`
- **Tests sans DB** : Utilisation de mocks pour la rapidité

## 🎨 Règles du Tri

### Ordre des couleurs
1. Carreaux (♦)
2. Cœur (♥)
3. Pique (♠)
4. Trèfle (♣)

### Ordre des valeurs
1. AS
2. 2, 3, 4, 5, 6, 7, 8, 9, 10
3. Valet
4. Dame
5. Roi

## 🐳 Docker

### Services disponibles
- **backend** : Application Symfony
- **frontend** : Application Vue.js
- **nginx** : Serveur web (production)

### Commandes utiles
```bash
# Voir les logs
docker-compose logs -f

# Redémarrer un service
docker-compose restart backend

# Nettoyer les volumes
docker-compose down -v

# Reconstruire une image
docker-compose build --no-cache backend
```

## 🔧 Développement

### Backend
```bash
# Accéder au conteneur backend
docker-compose exec backend sh

# Installer de nouvelles dépendances
composer require package-name

# Nettoyer le cache
php bin/console cache:clear

# Exécuter les tests
./run-pest-tests.sh
```

### Script de Démarrage
```bash
# Script de démarrage automatique
./start.sh

# Ce script effectue automatiquement :
# - Vérification de Docker et Docker Compose
# - Création du fichier .env si nécessaire
# - Construction et démarrage des conteneurs
# - Installation des dépendances
# - Tests de l'API
# - Affichage des URLs d'accès
```

### Frontend
```bash
# Accéder au conteneur frontend
docker-compose exec frontend sh

# Installer de nouvelles dépendances
npm install package-name

# Lancer le mode développement
npm run dev
```



## 🔒 Sécurité

- **CORS configuré** : Permet les requêtes cross-origin
- **Validation des données** : Côté serveur avec Symfony Validator
- **Gestion d'erreurs** : Try/catch appropriés
- **Variables d'environnement** : Secrets externalisés
- **Validation des données** : Côté serveur avec Symfony Validator

## 📈 Performance

- **Génération en mémoire** : Cartes générées rapidement sans DB
- **Build optimisé** : Vite pour le frontend
- **Images Docker optimisées** : Multi-stage builds
- **Tests rapides** : Mocks au lieu de vraie DB

## 🚀 Déploiement

### Production
```bash
# Build production
docker-compose -f docker-compose.prod.yml up --build

# Variables d'environnement
cp .env.example .env
# Configurer les variables de production
```

### Monitoring
- **Logs** : Docker logs + Symfony Monolog
- **Health checks** : Endpoints de vérification

## 🤝 Contribution

1. Fork le projet
2. Créer une branche feature (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.