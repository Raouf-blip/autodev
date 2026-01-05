<script setup>
import { ref } from 'vue'

const text = ref('')
</script>

<template>
  <div>
    <label for="input">Text: </label>
    <input type="text" id="input" v-model="text" />
    <p>
      You entered: <span>{{ text }}</span>
    </p>
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

label {
  font-size: 1.2rem;
}

input {
  padding: 8px;
  margin: 5px;
}

p {
  margin-top: 2%;
}

p span {
  font-weight: bold;
  color: #fff;
}
</style>
