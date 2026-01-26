import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import InputField from '../InputField.vue'

describe('InputField', () => {
  it('renders input field and label', () => {
    const wrapper = mount(InputField)

    expect(wrapper.find('label').exists()).toBe(true)
    expect(wrapper.find('label').text()).toBe('Text:')
    expect(wrapper.find('input').exists()).toBe(true)
    expect(wrapper.find('input').attributes('type')).toBe('text')
  })

  it('displays empty text initially', () => {
    const wrapper = mount(InputField)

    expect(wrapper.find('span').text()).toBe('')
  })

  it('updates displayed text when input changes', async () => {
    const wrapper = mount(InputField)
    const input = wrapper.find('input')

    await input.setValue('Hello')
    expect(wrapper.find('span').text()).toBe('Hello')

    await input.setValue('Hello World')
    expect(wrapper.find('span').text()).toBe('Hello World')
  })

  it('displays correct message format', () => {
    const wrapper = mount(InputField)
    const paragraph = wrapper.find('p')

    expect(paragraph.text()).toContain('You entered:')
  })

  it('handles empty string input', async () => {
    const wrapper = mount(InputField)
    const input = wrapper.find('input')

    await input.setValue('test')
    expect(wrapper.find('span').text()).toBe('test')

    await input.setValue('')
    expect(wrapper.find('span').text()).toBe('')
  })

  it('handles special characters in input', async () => {
    const wrapper = mount(InputField)
    const input = wrapper.find('input')

    await input.setValue('!@#$%^&*()')
    expect(wrapper.find('span').text()).toBe('!@#$%^&*()')
  })

  it('handles numbers in input', async () => {
    const wrapper = mount(InputField)
    const input = wrapper.find('input')

    await input.setValue('12345')
    expect(wrapper.find('span').text()).toBe('12345')
  })

  it('input has correct id attribute', () => {
    const wrapper = mount(InputField)
    const input = wrapper.find('input')

    expect(input.attributes('id')).toBe('input')
  })

  it('label has correct for attribute', () => {
    const wrapper = mount(InputField)
    const label = wrapper.find('label')

    expect(label.attributes('for')).toBe('input')
  })

  it('handles long text input', async () => {
    const wrapper = mount(InputField)
    const input = wrapper.find('input')
    const longText = 'This is a very long text that should still be displayed correctly'

    await input.setValue(longText)
    expect(wrapper.find('span').text()).toBe(longText)
  })
})
