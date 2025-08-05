import { config } from '@vue/test-utils'

// Configuration globale pour les tests
config.global.stubs = {
  'router-link': true,
  'router-view': true
} 