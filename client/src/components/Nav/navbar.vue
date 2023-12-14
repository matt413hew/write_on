<script>
import AddArticle from '../Article/AddArticle.vue'
import navItem from './navItem.vue'
export default {
  components: { navItem, AddArticle },
  name: 'Nav',
  data() {
    return {
      user: null,
      isOpen: false,
      pin: false,
      newA: false,
      routes: [
        {
          name: 'Dashboard',
          icon: 'bx:carousel',
          route: '/home',
          routeName: 'Home'
        },
        {
          name: 'All media',
          icon: 'la:newspaper',
          route: '/all',
          routeName: 'All'
        }
      ]
    }
  },
  mounted() {
    this.user = this.$main.getUser
    this.user.avatar = `https://api.dicebear.com/7.x/notionists/svg?seed=${this.user.first_name}'`
  },
  methods: {
    toggleSidebar() {
      this.isOpen = !this.isOpen
    },
    greet() {
      const currentTime = new Date().getHours() // Get the current hour

      if (currentTime < 12) {
        // Morning
        return 'Good morning'
      } else if (currentTime < 18) {
        // Afternoon
        return 'Good afternoon'
      } else {
        // Evening
        return 'Good evening'
      }
    },
    async logout() {
      this.$notify.Loading.pulse('Logging out...')
      await this.$main.logout()
      this.$router.push({ name: 'Login' })
      this.$notify.Loading.remove()
    }
  }
}
</script>
<template>
  <div class="flex flex-row h-screen">
    <add-article class="fixed bottom-5 right-5" :role="user?.role"></add-article>
    <div
      @mouseover="pin == true ? (isOpen = true) : (isOpen = true)"
      @mouseleave="pin == true ? (isOpen = true) : (isOpen = false)"
      class="hidden my-5 mr-2 lg:block"
    >
      <div class="h-full p-2 bg-neutral-900 rounded-r-3xl w-100">
        <div>
          <div class="flex justify-between">
            <br />
            <Transition
              enter-from-class="opacity-0 "
              enter-to-class="opacity-100 "
              enter-active-class="ease[cubic-bezier(.26,.61,0,1.12)] duration-[0.3s] delay-150"
            >
              <div class="text-slate-50" v-if="isOpen">
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
          <div class="flex flex-col p-2">
            <div class="flex items-center justify-center">
              <div>
                <span class="mb-4 text-5xl font-bold text-slate-50"
                  ><Icon icon="arcticons:writeilypro"
                /></span>
              </div>
              <div
                :class="{
                  'w-0 transform ': !isOpen,
                  'w-64 transform ': isOpen,
                  'duration-300 ease-in-out overflow-hidden': true
                }"
              >
                <span class="text-3xl text-slate-50"> Write_on </span>
                <div>
                  <span class="font-thin text-slate-50 whitespace-nowrap">
                    A simple writer/editor dashboard
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="flex flex-col gap-2">
            <nav-item
              v-for="route in routes"
              v-bind:key="route.name"
              :logo="route.icon"
              :expand="isOpen"
              :route="route.route"
              :routeName="route.routeName"
            >
              {{ route.name }}
            </nav-item>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full h-full px-2 pb-5 lg:pt-5">
      <div class="flex flex-col w-full h-full gap-3">
        <div class="block p-4 bg-neutral-900 text-slate-50 rounded-b-3xl lg:hidden">
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
        <div class="hidden py-2 bg-transparent px-9 rounded-3xl lg:block">
          <div class="flex items-center justify-between pb-2">
            <span class="font-light lg:text-5xl">
              <span class="text-slate-900"
                >{{ greet() }}, <span class="font-normal"> {{ user?.first_name }} </span>
              </span>
            </span>
            <div class="flex items-center gap-1">
              <div class="dropdown dropdown-bottom dropdown-end">
                <div tabindex="0" role="button" :class="user?.avatar ? user.avatar : null">
                  <img
                    class="bg-white border-4 rounded-full border-neutral-500 w-14 h-14"
                    :src="user?.avatar"
                    alt=""
                    srcset=""
                  />
                </div>
                <div class="">
                  <ul
                    tabindex="0"
                    class="dropdown-content bg-neutral-50 text-neutral-900 z-[1] menu p-2 m-1 shadow rounded-box w-52"
                  >
                    <li @click="logout()"><a>Logout</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <hr class="h-px my-1 bg-gray-200 border-0 dark:bg-neutral-400" />
        </div>
        <div class="w-full h-full">
          <Transition
            enter-from-class="opacity-0 "
            enter-to-class="opacity-100 "
            enter-active-class="ease[cubic-bezier(.26,.61,0,1.12)] duration-[0.3s] delay-150"
            leave-active-class="ease[cubic-bezier(.26,.61,0,1.12)] duration-[0.3s] delay-150"
          >
            <router-view></router-view>
          </Transition>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
