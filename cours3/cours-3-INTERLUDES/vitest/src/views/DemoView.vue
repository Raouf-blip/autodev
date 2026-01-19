<script setup>
import CounterComponent from '../components/CounterComponent.vue'
import InputField from '../components/InputField.vue'
</script>

<template>
  <div class="counter">
    <CounterComponent />
    <InputField />
  </div>
</template>

<style>
@media (min-width: 1024px) {
  .counter {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }
}
</style>
