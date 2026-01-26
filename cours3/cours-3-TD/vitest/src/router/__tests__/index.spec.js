import { describe, it, expect, beforeEach } from 'vitest'
import { createRouter, createMemoryHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import DemoView from '@/views/DemoView.vue'
import NotFoundView from '@/views/NotFoundView.vue'

describe('Router', () => {
  let router

  beforeEach(() => {
    router = createRouter({
      history: createMemoryHistory(),
      routes: [
        {
          path: '/',
          name: 'home',
          component: HomeView
        },
        {
          path: '/demo',
          name: 'demo',
          component: DemoView
        },
        {
          path: '/:pathMatch(.*)*',
          component: NotFoundView
        }
      ]
    })
  })

  it('navigates to home route', async () => {
    await router.push('/')
    expect(router.currentRoute.value.path).toBe('/')
    expect(router.currentRoute.value.name).toBe('home')
  })

  it('navigates to demo route', async () => {
    await router.push('/demo')
    expect(router.currentRoute.value.path).toBe('/demo')
    expect(router.currentRoute.value.name).toBe('demo')
  })

  it('navigates to 404 for unknown routes', async () => {
    await router.push('/unknown-route')
    expect(router.currentRoute.value.path).toBe('/unknown-route')
    expect(router.currentRoute.value.matched[0].components.default).toBe(NotFoundView)
  })

  it('has correct number of routes', () => {
    const routes = router.getRoutes()
    expect(routes.length).toBe(3)
  })

  it('home route uses HomeView component', async () => {
    await router.push('/')
    expect(router.currentRoute.value.matched[0].components.default).toBe(HomeView)
  })

  it('demo route uses DemoView component', async () => {
    await router.push('/demo')
    expect(router.currentRoute.value.matched[0].components.default).toBe(DemoView)
  })

  it('handles navigation from home to demo', async () => {
    await router.push('/')
    expect(router.currentRoute.value.path).toBe('/')

    await router.push('/demo')
    expect(router.currentRoute.value.path).toBe('/demo')
  })

  it('handles navigation from demo to home', async () => {
    await router.push('/demo')
    expect(router.currentRoute.value.path).toBe('/demo')

    await router.push('/')
    expect(router.currentRoute.value.path).toBe('/')
  })

  it('routes are defined with correct names', async () => {
    const routes = router.getRoutes()
    const homeRoute = routes.find(r => r.name === 'home')
    const demoRoute = routes.find(r => r.name === 'demo')

    expect(homeRoute).toBeDefined()
    expect(demoRoute).toBeDefined()
    expect(homeRoute.path).toBe('/')
    expect(demoRoute.path).toBe('/demo')
  })

  it('can navigate using route names', async () => {
    await router.push({ name: 'home' })
    expect(router.currentRoute.value.name).toBe('home')

    await router.push({ name: 'demo' })
    expect(router.currentRoute.value.name).toBe('demo')
  })

  it('handles multiple 404 scenarios', async () => {
    const invalidPaths = ['/invalid', '/test/nested', '/demo/extra']

    for (const path of invalidPaths) {
      await router.push(path)
      expect(router.currentRoute.value.matched[0].components.default).toBe(NotFoundView)
    }
  })
})
