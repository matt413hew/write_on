<script>
export default {
  name: 'NavItem',
  emits: [],
  props: {
    expand: {
      type: Boolean,
      default: false
    },
    logo: {
      type: String,
      default: 'ph:linux-logo'
    },
    route: {
      type: String,
      default: '/'
    },
    routeName: {
      type: String,
      default: null
    }
  },
  components: {},
  data() {
    return {}
  },
  watch: {},
  mounted() {},
  methods: {}
}
</script>
<template>
  <router-link :to="route">
    <div
      class="flex items-center justify-center p-3 rounded-full"
      style="cursor: pointer"
      :class="{
        'gap-0 transform': !expand,
        'gap-2 transform': expand,
        'duration-300 ease-in-out': true,
        'text-slate-50': $route.name != routeName,
        'text-neutral-900 bg-slate-300': $route.name == routeName
      }"
    >
      <Icon class="text-3xl" :icon="logo" />
      <span
        :class="{
          'w-0 transform ': !expand,
          'w-48 transform ': expand,
          '  duration-300 ease-in-out overflow-hidden': true
        }"
        class="whitespace-nowrap"
      >
        <slot></slot>
      </span>
    </div>
  </router-link>
</template>

<style scoped></style>
