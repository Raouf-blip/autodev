// stores/counter.spec.ts
import { setActivePinia, createPinia } from 'pinia'
import { describe, it, beforeEach } from 'vitest'

describe('Counter Store', () => {
  beforeEach(() => {
    // creates a fresh pinia and makes it active
    // so it's automatically picked up by any useStore() call
    // without having to pass it to it: `useStore(pinia)`
    setActivePinia(createPinia())
  })

  it('increments', () => {})

  it('decrements', () => {})
})
