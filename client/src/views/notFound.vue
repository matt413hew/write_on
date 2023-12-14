<script>
export default {
  name: 'NotFound',
  emits: [],
  props: {},
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
  <div class="flex items-center justify-center w-screen h-screen bg-neutral-200 text-neutral-800">
    <div class="text-center">
      <div class="font-bold text-8xl">404</div>
      <div class="text-5xl font-bold">Not Found</div>
      <div class="flex justify-center p-3">
        <router-link to="/">
          <Tbtn> Return to Dashboard </Tbtn>
        </router-link>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
