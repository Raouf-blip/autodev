<template>
  <div class="container mx-auto px-4">
    <section v-if="property" class="bg-white">
      <div class="container mx-auto mb-6 px-52">
        <fwb-carousel
          :pictures="property.images.map(image => ({ 'src': image.link, 'alt': image.id.toString() } as PictureItem))" />
      </div>
      <div class="container mx-auto">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-blue-600">
          {{ property.name }}
        </h5>
        <p>{{ property.description }}</p>
      </div>
      <div class="inline-flex">
        <div v-for="option in property.options" :key="option.id">
          <fwb-badge class="text-md">{{ option.name }}</fwb-badge>
        </div>
      </div>
    </section>
  </div>
</template>

<script lang='ts' setup>
import { ref } from 'vue';
import { FwbCarousel, FwbBadge } from 'flowbite-vue'
import type { Property } from '../types';
import { useRoute } from "vue-router";
import { PictureItem } from 'flowbite-vue/components/FwbCarousel/types.js';
const apiUrl = import.meta.env.VITE_API_URL;


const property = ref<Property | null>(null);
const id = useRoute().params.id
fetch(apiUrl + '/property/' + id)
  .then(response => response.json())
  .then(response => {
    property.value = response
  });
</script>