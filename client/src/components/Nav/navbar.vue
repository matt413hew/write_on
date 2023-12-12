<script>
import navItem from './navItem.vue'
export default {
  components: { navItem },
  name: 'Nav',
  data() {
    return {
      isOpen: false,
      pin: false,
      routes: [
        {
          name: 'All media',
          icon: 'la:newspaper',
          route: '/all'
        }
      ]
    }
  },
  methods: {
    toggleSidebar() {
      this.isOpen = !this.isOpen
    }
  }
}
</script>
<template>
  <div class="flex flex-row h-screen">
    <div
      @mouseover="pin == true ? (isOpen = true) : (isOpen = true)"
      @mouseleave="pin == true ? (isOpen = true) : (isOpen = false)"
      class="hidden mx-2 my-5 lg:block"
    >
      <div class="h-full p-2 bg-white rounded-3xl w-100">
        <div>
          <div class="flex justify-between">
            <br />
            <Transition
              enter-from-class="opacity-0 "
              enter-to-class="opacity-100 "
              enter-active-class="ease[cubic-bezier(.26,.61,0,1.12)] duration-[0.3s] delay-150"
            >
              <div v-if="isOpen">
                <div v-if="!pin">
                  <Icon
                    v-tooltip="'Pin sidebar'"
                    @click="pin = !pin"
                    style="cursor: pointer"
                    class="text-2xl"
                    icon="ic:outline-push-pin"
                  />
                </div>
                <div v-else>
                  <Icon
                    v-tooltip="'Unpin sidebar'"
                    @click="pin = !pin"
                    style="cursor: pointer"
                    class="text-2xl"
                    icon="ic:outline-pin-off"
                  />
                </div>
              </div>
            </Transition>
          </div>
          <div class="flex items-center justify-center gap-2 p-2">
            <div>
              <span class="mb-4 font-bold text-7xl"><Icon icon="arcticons:writeilypro" /></span>
            </div>
          </div>
          <nav-item
            v-for="route in routes"
            v-bind:key="route.name"
            :logo="route.icon"
            :expand="isOpen"
            :route="route.route"
          >
            {{ route.name }}
          </nav-item>
        </div>
      </div>
    </div>
    <div class="w-full h-full px-2 py-5">
      <div class="flex flex-col w-full h-full gap-3">
        <div class="block p-4 bg-white rounded-3xl lg:hidden">
          <div class="flex items-center justify-between">
            <br />
            <span class="flex gap-2 text-4xl font-bold"
              ><Icon icon="arcticons:writeilypro" />Write_on</span
            >
            <div>
              <Icon class="text-2xl" icon="icon-park-outline:hamburger-button" />
            </div>
          </div>
        </div>
        <div class="hidden py-4 bg-white px-9 rounded-3xl lg:block">
          <span class="xl:text-4xl lg:text-3xl">
            <span class="font-bold text-slate-900">Write_on : :</span>&nbsp; A simple writer/editor
            dashboard
          </span>
        </div>
        <div class="w-full h-full">
          <router-view></router-view>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
