<template>
  <div 
    class="card relative overflow-hidden transition-all duration-300 hover:scale-105 hover:shadow-xl cursor-pointer group"
    :class="cardColorClass"
  >
    <!-- Effet de brillance au survol -->
    <div class="absolute inset-0 bg-gradient-to-br from-white/0 via-white/20 to-white/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
    
    <!-- Effet de brillance animé -->
    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none animate-card-shine"></div>
    
    <!-- En-tête de la carte -->
    <div class="flex justify-between items-start mb-3">
      <span class="text-lg font-bold tracking-wide">{{ card.value }}</span>
      <span class="text-sm opacity-80">{{ getColorSymbol(card.color) }}</span>
    </div>

    <!-- Symbole principal -->
    <div class="text-center mb-3 flex-1 flex items-center justify-center">
      <span class="text-4xl opacity-90">{{ getColorSymbol(card.color) }}</span>
    </div>

    <!-- Pied de la carte -->
    <div class="flex justify-between items-end">
      <span class="text-sm opacity-80">{{ getColorSymbol(card.color) }}</span>
      <span class="text-lg font-bold tracking-wide transform rotate-180">{{ card.value }}</span>
    </div>

    <!-- Nom de la carte (tooltip amélioré) -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-end justify-center pb-2">
      <span class="text-xs font-semibold text-white bg-black/90 px-3 py-1.5 rounded-full shadow-lg backdrop-blur-sm">
        {{ card.displayName }}
      </span>
    </div>

    <!-- Effet de coin plié -->
    <div class="absolute top-0 right-0 w-0 h-0 border-l-[20px] border-l-transparent border-t-[20px] border-t-gray-300/30"></div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  card: {
    type: Object,
    required: true
  }
})

const cardColorClass = computed(() => {
  const redColors = ['Cœur', 'Carreaux']
  return redColors.includes(props.card.color) ? 'card-red' : 'card-black'
})

const getColorSymbol = (color) => {
  const symbols = {
    'Carreaux': '♦',
    'Cœur': '♥',
    'Pique': '♠',
    'Trèfle': '♣'
  }
  return symbols[color] || color
}
</script>

<style scoped>
.card {
  aspect-ratio: 2.5/3.5;
  min-height: 140px;
  display: flex;
  flex-direction: column;
}
</style> 