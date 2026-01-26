import { describe, it, expect, beforeEach } from 'vitest'
import { mount } from '@vue/test-utils'
import { createPinia, setActivePinia } from 'pinia'
import CounterComponent from '../CounterComponent.vue'
import { useCounterStore } from '@/stores/counter'

describe('CounterComponent', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
  })

  it('renders counter value from store', () => {
    const wrapper = mount(CounterComponent)
    expect(wrapper.find('#counter').text()).toBe('0')
  })

  it('increments counter when increment button is clicked', async () => {
    const wrapper = mount(CounterComponent)
    const buttons = wrapper.findAll('button')
    const incrementButton = buttons[1]

    await incrementButton.trigger('click')
    expect(wrapper.find('#counter').text()).toBe('1')

    await incrementButton.trigger('click')
    expect(wrapper.find('#counter').text()).toBe('2')
  })

  it('decrements counter when decrement button is clicked', async () => {
    const wrapper = mount(CounterComponent)
    const buttons = wrapper.findAll('button')
    const decrementButton = buttons[0]

    await decrementButton.trigger('click')
    expect(wrapper.find('#counter').text()).toBe('-1')

    await decrementButton.trigger('click')
    expect(wrapper.find('#counter').text()).toBe('-2')
  })

  it('handles multiple increment and decrement operations', async () => {
    const wrapper = mount(CounterComponent)
    const buttons = wrapper.findAll('button')
    const decrementButton = buttons[0]
    const incrementButton = buttons[1]

    await incrementButton.trigger('click')
    await incrementButton.trigger('click')
    await incrementButton.trigger('click')
    expect(wrapper.find('#counter').text()).toBe('3')

    await decrementButton.trigger('click')
    expect(wrapper.find('#counter').text()).toBe('2')
  })

  it('displays correct button labels', () => {
    const wrapper = mount(CounterComponent)
    const buttons = wrapper.findAll('button')

    expect(buttons[0].text()).toBe('Decrement')
    expect(buttons[1].text()).toBe('Increment')
  })

  it('renders h3 with counter label', () => {
    const wrapper = mount(CounterComponent)
    const h3 = wrapper.find('h3')

    expect(h3.exists()).toBe(true)
    expect(h3.text()).toContain('Counter:')
  })

  it('uses counter store correctly', () => {
    const wrapper = mount(CounterComponent)
    const store = useCounterStore()

    expect(store.count).toBe(0)
  })
})
