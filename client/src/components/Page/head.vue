<script>
export default {
  name: 'Page Header',
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
  <div class="bg-white m-0 py-5 px-9 rounded-3xl">
    <div class="text-4xl pb-3 text-slate-800 font-semibold"><slot></slot></div>
    <div class="border border-slate-400"></div>
  </div>
</template>

<style scoped></style>
