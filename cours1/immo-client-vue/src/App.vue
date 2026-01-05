<template>
  <div id="app">
    <fwb-navbar>
      <template #logo>
        <fwb-navbar-logo class="text-blue-600" alt="Flowbite logo" image-url="/vite.svg" link="/">
          ImmoWeb
        </fwb-navbar-logo>
      </template>
      <template #default="{ isShowMenu }">
        <fwb-navbar-collapse :is-show-menu="isShowMenu">
          <fwb-navbar-link is-active link="/">
            Home
          </fwb-navbar-link>
        </fwb-navbar-collapse>
      </template>
    </fwb-navbar>
    <router-view></router-view>
  </div>
</template>

<script lang="ts" setup>
import {
  FwbNavbar,
  FwbNavbarCollapse,
  FwbNavbarLink,
  FwbNavbarLogo
} from 'flowbite-vue'
</script>