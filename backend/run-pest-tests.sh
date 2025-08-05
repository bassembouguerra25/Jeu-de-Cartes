#!/bin/bash

echo "🧪 Exécution des tests Pest..."

# Vérifier si Pest est installé
if ! command -v ./vendor/bin/pest &> /dev/null; then
    echo "❌ Pest n'est pas installé. Installation..."
    composer require pestphp/pest --dev
fi

# Exécuter les tests Pest
./vendor/bin/pest --colors=always

echo "✅ Tests Pest terminés !" 