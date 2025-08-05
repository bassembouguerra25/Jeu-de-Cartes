import { defineStore } from 'pinia'
import axios from 'axios'

const API_BASE_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000'

export const useGameStore = defineStore('game', {
  state: () => ({
    currentHand: null,
    rules: {
      colors: ['Carreaux', 'Cœur', 'Pique', 'Trèfle'],
      values: ['AS', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Valet', 'Dame', 'Roi'],
      handSize: 10
    },
    loading: false,
    error: null
  }),

  getters: {
    hasCurrentHand: (state) => state.currentHand !== null
  },

  actions: {
    async drawNewHand() {
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.post(`${API_BASE_URL}/api/games/draw`)
        
        if (response.data.success) {
          this.currentHand = response.data.data
          return this.currentHand
        } else {
          throw new Error(response.data.error || 'Erreur lors du tirage des cartes')
        }
      } catch (error) {
        this.error = error.response?.data?.error || error.message
        throw error
      } finally {
        this.loading = false
      }
    },

    async getRules() {
      try {
        const response = await axios.get(`${API_BASE_URL}/api/games/rules`)
        
        if (response.data.success) {
          this.rules = response.data.data
          return this.rules
        } else {
          throw new Error(response.data.error || 'Erreur lors du chargement des règles')
        }
      } catch (error) {
        console.error('Erreur lors du chargement des règles:', error)
        // Retourner les règles par défaut en cas d'erreur
        return this.rules
      }
    },

    clearCurrentHand() {
      this.currentHand = null
    },

    clearError() {
      this.error = null
    }
  }
}) 