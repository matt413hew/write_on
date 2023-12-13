<template>
  <div class="relative flex tbutton" :class="disabled ? 'opacity-50 pointer-events-none' : ''">
    <span
      v-if="ping"
      :class="
        'absolute inline-flex h-4 w-4 -right-2 -top-1 rounded-full bg-' +
        pingColor.main +
        '-500  hover:scale-110 transition-transform ease-in-out duration-100'
      "
    >
    </span>
    <span
      v-if="ping"
      :class="
        'animate-ping absolute inline-flex h-4 w-4 -right-2 -top-1 rounded-full bg-' +
        pingColor.secondary +
        '-400  hover:scale-110 transition-transform ease-in-out duration-100'
      "
    >
    </span>
    <span
      :class="[
        stretch == true && 'p-' + pad + ' w-full',
        stretch != true && 'p-' + pad,
        selected == false && ' bg-' + bg + '-500 ',
        selected == true && ' bg-' + bg + '-700 '
      ]"
      class="flex items-center justify-center gap-1 text-white transition-transform duration-100 ease-in-out shadow cursor-pointer rounded-3xl hover:scale-110 hover:z-20"
    >
      <slot></slot>
    </span>
  </div>
</template>

<script>
export default {
  name: 'TButton',
  emits: [],
  props: {
    disabled: {
      type: Boolean,
      default: false
    },
    selected: {
      type: Boolean,
      default: true
    },
    stretch: {
      type: Boolean,
      default: false
    },
    bg: {
      type: String,
      default: 'neutral'
    },
    pad: {
      type: String,
      default: '3'
    },
    ping: {
      type: Boolean,
      default: false
    },
    pingColor: {
      type: Object,
      default: {
        main: 'emerald',
        secondary: 'green'
      }
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
<style scoped></style>
