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
      class="flex justify-center items-center rounded-full bg-slate-200 p-3"
      style="cursor: pointer"
      :class="{
        'gap-0 transform': !expand,
        'gap-2 transform': expand,
        'duration-300 ease-in-out': true
      }"
    >
      <Icon class="text-3xl" :icon="logo" />
      <span
        :class="{
          'w-0 transform ': !expand,
          'w-56 transform ': expand,
          '  duration-300 ease-in-out overflow-hidden': true
        }"
      >
        <slot></slot>
      </span>
    </div>
  </router-link>
</template>

<style scoped></style>
