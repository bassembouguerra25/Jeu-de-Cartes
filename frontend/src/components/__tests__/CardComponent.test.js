import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import CardComponent from '../CardComponent.vue'

describe('CardComponent', () => {
  const mockCard = {
    id: 1,
    color: 'Cœur',
    value: 'AS',
    displayName: 'AS de Cœur'
  }

  it('renders card information correctly', () => {
    const wrapper = mount(CardComponent, {
      props: {
        card: mockCard
      }
    })

    expect(wrapper.text()).toContain('AS')
    expect(wrapper.text()).toContain('♥')
    expect(wrapper.text()).toContain('AS de Cœur')
  })

  it('applies correct color class for red cards', () => {
    const wrapper = mount(CardComponent, {
      props: {
        card: { ...mockCard, color: 'Cœur' }
      }
    })

    expect(wrapper.classes()).toContain('card-red')
  })

  it('applies correct color class for black cards', () => {
    const wrapper = mount(CardComponent, {
      props: {
        card: { ...mockCard, color: 'Pique' }
      }
    })

    expect(wrapper.classes()).toContain('card-black')
  })

  it('displays correct symbols for each color', () => {
    const colors = ['Carreaux', 'Cœur', 'Pique', 'Trèfle']
    const symbols = ['♦', '♥', '♠', '♣']

    colors.forEach((color, index) => {
      const wrapper = mount(CardComponent, {
        props: {
          card: { ...mockCard, color }
        }
      })

      expect(wrapper.text()).toContain(symbols[index])
    })
  })

  it('shows tooltip on hover', async () => {
    const wrapper = mount(CardComponent, {
      props: {
        card: mockCard
      }
    })

    const tooltip = wrapper.find('.absolute')
    expect(tooltip.exists()).toBe(true)
    expect(tooltip.text()).toContain('AS de Cœur')
  })
}) 