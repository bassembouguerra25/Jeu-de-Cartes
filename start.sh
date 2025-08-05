#!/bin/bash

echo "🎴 Démarrage de l'application Jeu de Cartes"
echo "=========================================="

# Vérifier si Docker est installé
if ! command -v docker &> /dev/null; then
    echo "❌ Docker n'est pas installé. Veuillez installer Docker et Docker Compose."
    exit 1
fi

# Vérifier si Docker Compose est installé
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose n'est pas installé. Veuillez installer Docker Compose."
    exit 1
fi

echo "✅ Docker et Docker Compose sont installés"

# Créer le fichier .env pour le backend si il n'existe pas
if [ ! -f "backend/.env" ]; then
    echo "📝 Création du fichier .env pour le backend..."
    cat > backend/.env << EOF
DATABASE_URL="postgresql://cardgame_user:cardgame_password@postgres:5432/cardgame?serverVersion=15&charset=utf8"
REDIS_URL="redis://redis:6379"
APP_ENV=dev
APP_SECRET=your-secret-key-here
CORS_ALLOW_ORIGIN=*
EOF
    echo "✅ Fichier .env créé"
fi

# Construire et démarrer les conteneurs
echo "🐳 Construction et démarrage des conteneurs..."
docker-compose up --build -d

# Attendre que les services soient prêts
echo "⏳ Attente du démarrage des services..."
sleep 30

# Vérifier que les conteneurs sont en cours d'exécution
echo "🔍 Vérification de l'état des conteneurs..."
if ! docker-compose ps | grep -q "Up"; then
    echo "❌ Erreur : Les conteneurs ne sont pas démarrés correctement"
    docker-compose logs
    exit 1
fi

# Installer les dépendances du backend
echo "📦 Installation des dépendances Symfony..."
docker-compose exec -T backend composer install --no-interaction

# Créer la base de données et les tables
echo "🗄️ Initialisation de la base de données..."
docker-compose exec -T backend php bin/console doctrine:database:create --if-not-exists --no-interaction

# Vérifier s'il y a des migrations à créer
echo "🔧 Vérification des migrations..."
if [ ! "$(ls -A backend/migrations/ 2>/dev/null)" ]; then
    echo "📝 Création des migrations..."
    docker-compose exec -T backend php bin/console make:migration --no-interaction
fi

# Exécuter les migrations
echo "🚀 Exécution des migrations..."
docker-compose exec -T backend php bin/console doctrine:migrations:migrate --no-interaction

# Vérifier que l'API fonctionne
echo "🧪 Test de l'API..."
sleep 5
if curl -s http://localhost:8000/api/games > /dev/null; then
    echo "✅ API fonctionnelle"
else
    echo "⚠️  L'API n'est pas encore prête, mais les services sont démarrés"
fi

# Vérifier l'état final des conteneurs
echo "🔍 État final des conteneurs :"
docker-compose ps

echo ""
echo "🎉 Application démarrée avec succès !"
echo ""
echo "📱 Accès à l'application :"
echo "   Frontend : http://localhost:3000"
echo "   Backend API : http://localhost:8000"
echo ""
echo "📊 Commandes utiles :"
echo "   Voir les logs : docker-compose logs -f"
echo "   Arrêter : docker-compose down"
echo "   Redémarrer : docker-compose restart"
echo ""
echo "🧪 Tests :"
echo "   Backend : docker-compose exec backend php bin/phpunit"
echo "   Frontend : docker-compose exec frontend npm test"
echo ""
echo "🚀 Bon développement !" 