import { describe, it, expect, vi } from 'vitest'

import { mount } from '@vue/test-utils'
import { createTestingPinia } from '@pinia/testing'
import Counter from '../CounterComponent.vue'

function mountCounter(x = 0) {
  const wrapper = mount(Counter, {
    global: {
      plugins: [
        createTestingPinia({
          createSpy: vi.fn,
          initialState: {
            counter: { count: x } // start the counter at x instead of 0
          }
        })
      ]
    }
  })
  return wrapper
}

describe('Counter', () => {
  it('renders properly', () => {
    const wrapper = mountCounter(50)
    expect(wrapper.text()).toContain('Counter: 50')
  })
  describe('Clicks', () => {
    it('increments counter', () => {})
    it('decrements counter', () => {})
  })
})
