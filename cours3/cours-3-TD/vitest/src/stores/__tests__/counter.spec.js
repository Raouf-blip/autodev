import { describe, it, expect, beforeEach } from 'vitest'
import { setActivePinia, createPinia } from 'pinia'
import { useCounterStore } from '../counter'

describe('Counter Store', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
  })

  it('initializes with count of 0', () => {
    const store = useCounterStore()
    expect(store.count).toBe(0)
  })

  it('increments count', () => {
    const store = useCounterStore()
    store.increment()
    expect(store.count).toBe(1)
  })

  it('increments count multiple times', () => {
    const store = useCounterStore()
    store.increment()
    store.increment()
    store.increment()
    expect(store.count).toBe(3)
  })

  it('decrements count', () => {
    const store = useCounterStore()
    store.decrement()
    expect(store.count).toBe(-1)
  })

  it('decrements count multiple times', () => {
    const store = useCounterStore()
    store.decrement()
    store.decrement()
    store.decrement()
    expect(store.count).toBe(-3)
  })

  it('handles mixed increment and decrement operations', () => {
    const store = useCounterStore()
    store.increment()
    store.increment()
    store.decrement()
    expect(store.count).toBe(1)
  })

  it('returns to zero after equal increments and decrements', () => {
    const store = useCounterStore()
    store.increment()
    store.increment()
    store.increment()
    store.decrement()
    store.decrement()
    store.decrement()
    expect(store.count).toBe(0)
  })

  it('allows count to go negative', () => {
    const store = useCounterStore()
    store.decrement()
    store.decrement()
    store.decrement()
    store.decrement()
    store.decrement()
    expect(store.count).toBe(-5)
  })

  it('maintains state across multiple operations', () => {
    const store = useCounterStore()

    store.increment()
    expect(store.count).toBe(1)

    store.increment()
    expect(store.count).toBe(2)

    store.decrement()
    expect(store.count).toBe(1)

    store.increment()
    expect(store.count).toBe(2)
  })

  it('provides all expected store properties', () => {
    const store = useCounterStore()

    expect(store).toHaveProperty('count')
    expect(store).toHaveProperty('increment')
    expect(store).toHaveProperty('decrement')
  })

  it('increment and decrement are functions', () => {
    const store = useCounterStore()

    expect(typeof store.increment).toBe('function')
    expect(typeof store.decrement).toBe('function')
  })

  it('handles large number of increments', () => {
    const store = useCounterStore()

    for (let i = 0; i < 100; i++) {
      store.increment()
    }

    expect(store.count).toBe(100)
  })

  it('handles large number of decrements', () => {
    const store = useCounterStore()

    for (let i = 0; i < 100; i++) {
      store.decrement()
    }

    expect(store.count).toBe(-100)
  })
})
