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
  <div class="pb-5 m-0 bg-transparent px-9 rounded-3xl">
    <div class="pb-3 text-4xl font-semibold text-slate-800"><slot></slot></div>
  </div>
</template>

<style scoped></style>
