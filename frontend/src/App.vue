<template>
  <div id="app" class="min-h-screen">
    <header class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-6">
          <div class="flex items-center">
            <h1 class="text-2xl font-bold text-gray-900">🎴 Jeu de Cartes</h1>
          </div>
          <nav class="flex space-x-4">
            <!-- Navigation supprimée -->
          </nav>
        </div>
      </div>
    </header>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <router-view />
    </main>
  </div>
</template>

<script setup>
// Le composant principal utilise le router pour afficher les pages
</script> 