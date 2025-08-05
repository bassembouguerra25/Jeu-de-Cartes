<template>
  <div class="space-y-8">
    <!-- En-tête -->
    <div class="text-center">
      <h2 class="text-3xl font-bold text-gray-900 mb-4">Tirage de Cartes</h2>
      <p class="text-lg text-gray-600">
        Tirez une main de 10 cartes aléatoires et voyez-les triées par couleur et valeur
      </p>
    </div>

    <!-- Bouton pour tirer une nouvelle main -->
    <div class="text-center">
      <button 
        @click="drawNewHand" 
        :disabled="loading"
        class="btn-primary text-lg px-8 py-3 disabled:opacity-50 disabled:cursor-not-allowed"
      >
        <span v-if="loading">Tirage en cours...</span>
        <span v-else>🎲 Tirer une nouvelle main</span>
      </button>
    </div>

    <!-- Affichage de la main -->
    <div v-if="currentHand" class="space-y-8">
      <!-- Cartes non triées -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-4 text-orange-600">
          🃏 Main non triée ({{ currentHand.cards.length }} cartes)
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
          <CardComponent 
            v-for="card in currentHand.cards" 
            :key="card.id" 
            :card="card" 
          />
        </div>
      </div>

      <!-- Cartes triées -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-xl font-semibold mb-4 text-green-600">
          ✅ Main triée par couleur et valeur
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
          <CardComponent 
            v-for="card in currentHand.sortedCards" 
            :key="card.id" 
            :card="card" 
          />
        </div>
      </div>

      <!-- Règles du jeu -->
      <div class="bg-blue-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-3 text-blue-900">📋 Règles du tri</h3>
        <div class="grid md:grid-cols-2 gap-4 text-sm">
          <div>
            <h4 class="font-medium text-blue-800 mb-2">Ordre des couleurs :</h4>
            <p class="text-blue-700">{{ rules.colors.join(' → ') }}</p>
          </div>
          <div>
            <h4 class="font-medium text-blue-800 mb-2">Ordre des valeurs :</h4>
            <p class="text-blue-700">{{ rules.values.join(' → ') }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Message d'erreur -->
    <div v-if="error" class="bg-red-50 border border-red-200 rounded-lg p-4">
      <p class="text-red-800">{{ error }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useGameStore } from '../stores/game'
import CardComponent from '../components/CardComponent.vue'

const gameStore = useGameStore()
const loading = ref(false)
const error = ref('')
const currentHand = ref(null)
const rules = ref({
  colors: ['Carreaux', 'Cœur', 'Pique', 'Trèfle'],
  values: ['AS', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Valet', 'Dame', 'Roi']
})

const drawNewHand = async () => {
  loading.value = true
  error.value = ''
  
  try {
    currentHand.value = await gameStore.drawNewHand()
  } catch (err) {
    error.value = 'Erreur lors du tirage des cartes: ' + err.message
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  try {
    const rulesData = await gameStore.getRules()
    rules.value = rulesData
  } catch (err) {
    console.error('Erreur lors du chargement des règles:', err)
  }
})
</script> 