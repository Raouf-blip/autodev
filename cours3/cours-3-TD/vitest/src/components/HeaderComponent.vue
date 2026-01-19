<script setup>
import { RouterLink } from 'vue-router'
import HelloWorld from './HelloWorld.vue'
</script>
<template>
  <header>
    <img alt="Vue logo" class="logo" src="@/assets/logo.svg" width="125" height="125" />

    <div class="wrapper">
      <HelloWorld msg="You did it!" />

      <nav>
        <RouterLink id="home" to="/">Home</RouterLink>
        <RouterLink id="demo" to="/demo">Demo</RouterLink>
      </nav>
    </div>
  </header>
</template>
