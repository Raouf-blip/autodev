<template>
    <div className="px-4 mx-auto max-w-screen-xl text-center lg:py-16">
      <h1 className="mb-4 text-4xl font-extrabold tracking-tight leading-none text-blue-600 md:text-5xl lg:text-6x">
          Immo Web
      </h1>
    </div>
    <section v-if="properties" class="bg-white">
    <div class="x-4 mx-auto max-w-screen-xl text-center lg:py-8">
      <div class="container mx-auto grid gap-6 mb-6 md:grid-cols-3">
        <div v-for="property in properties" :key="property.id">
          <router-link to="/" class="c-card block bg-white shadow-md hover:shadow-xl rounded-lg overflow-hidden">
            <div class="relative pb-48 overflow-hidden">
              <img class="absolute inset-0 h-full w-full object-cover" :src="property.mainImage" alt="">
            </div>
            <div class="p-4">
              <div v-if="property.type === 'house'">
                <span
                  class="inline-block px-2 py-1 leading-none bg-blue-200 text-blue-800 rounded-full font-semibold uppercase tracking-wide text-xs">{{
                    property.type }}</span>
              </div>
              <div v-else-if="property.type === 'commercial'">
                <span
                  class="inline-block px-2 py-1 leading-none bg-green-200 text-green-800 rounded-full font-semibold uppercase tracking-wide text-xs">{{
                    property.type }}</span>
              </div>
              <div v-else-if="property.type === 'apartment'">
                <span
                  class="inline-block px-2 py-1 leading-none bg-orange-200 text-blue-800 rounded-full font-semibold uppercase tracking-wide text-xs">{{
                    property.type }}</span>
              </div>
              <div v-else>
              </div>
              <h2 class="mt-2 mb-2  font-bold">{{ property.name }}</h2>
              <text-clamp class="text-sm h-20 text-justify" :max-lines="3" :text="property.description"></text-clamp>
              <div class="mt-3 flex items-center justify-end">
                <span class="text-sm font-semibold">$&nbsp;</span><span class="font-bold text-xl">{{ property.price
                }}</span>
              </div>
            </div>
            <div class="p-4 border-t border-b text-xs text-gray-700">
              <span class="flex items-center mb-1">
                <i class="far fa-clock fa-fw mr-2 text-gray-900"></i>{{ property.surface }} m²
              </span>
              <span class="flex items-center">
                <i class="far fa-address-card fa-fw text-gray-900 mr-2"></i>{{ property.city }}
              </span>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </section>
  <section v-else>
    <div class="x-4 mx-auto max-w-screen-xl text-center lg:py-8">
      <p>No properties found</p>
    </div>
  </section>
</template>


<script lang="ts" setup>
import { ref } from 'vue';
import type { Property } from '../types';
import TextClamp from 'vue3-text-clamp';
const apiUrl = import.meta.env.VITE_API_URL;

const properties = ref<Array<Property> | null>(null);
fetch(apiUrl + '/property?sold=false')
  .then(response => response.json())
  .then(response => {
    properties.value = response.data.map((property: Property) => {
      if (property.images && property.images.length > 0) {
        property.mainImage = property.images[0].link;
      } else {
        property.mainImage = "https://placehold.co/400x400?text=%5Cn";
      }
      return property;
    });
  });
</script>
