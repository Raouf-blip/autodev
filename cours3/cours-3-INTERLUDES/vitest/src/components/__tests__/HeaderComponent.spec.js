import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import router from '@/router'
import Header from '../HeaderComponent.vue'

function mountHeader() {
  const wrapper = mount(Header, {
    global: {
      plugins: [router]
    }
  })
  return wrapper
}

describe('Header', () => {
  const wrapper = mountHeader()
  it('renders properly', () => {
    expect(wrapper.text()).toContain('Demo')
    expect(wrapper.text()).toContain('Home')
  })
  describe('Navigation', () => {
    it('navigate to Demo', async () => {})
    it('navigate to Home', async () => {})
  })
})
