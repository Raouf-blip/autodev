<script setup>
import { useCounterStore } from '@/stores/counter'

const counterStore = useCounterStore()
</script>

<template>
  <div>
    <h3>
      Counter: <span id="counter">{{ counterStore.count }}</span>
    </h3>
    <div class="actions">
      <button @click="counterStore.decrement()">Decrement</button>
      <button @click="counterStore.increment()">Increment</button>
    </div>
  </div>
</template>

<style scoped>
div {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  width: 75%;
  margin: auto;
}

.actions {
  margin: 5% 0;
  display: flex;
  flex-direction: row;
  justify-content: space-evenly;
}

button {
  padding: 4%;
  color: var(--color-text);
  border: 1px solid var(--color-text);
  background-color: transparent;
  border-radius: 5%;
  cursor: pointer;
}

button:hover {
  border-color: var(--color-heading);
  color: var(--color-heading);
}
h3 {
  font-size: 1.2rem;
}

#counter {
  color: #fff;
  font-weight: bold;
}
</style>
