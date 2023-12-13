<template>
  <div>
    <Tbtn v-tooltip="'Create a new article'" pad="4" onclick="create_modal.showModal()">
      <div class="lg:p-0 p-2 flex items-center gap-2">
        <Icon class="lg:text-2xl text-4xl" icon="streamline:add-1-solid" />
        <span class="hidden lg:block">Create new article</span>
      </div>
    </Tbtn>
    <dialog id="create_modal" class="modal">
      <div class="bg-white text-neutral-800 max-w-7xl modal-box rounded-3xl">
        <h3 class="text-3xl font-bold">New Article</h3>
        <div class="text-end text-neutral-600"></div>
        <EditArticle></EditArticle>
      </div>
    </dialog>
  </div>
</template>

<script>
export default {
  name: 'Add Article',
  emits: [],
  props: {},
  components: {},
  data() {
    return {
      article: null
    }
  },
  watch: {},
  mounted() {},
  methods: {}
}
</script>
<style scoped></style>
