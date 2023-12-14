<script>
export default {
  name: 'Add Article',
  emits: [],
  props: {
    role: {
      type: String,
      default: null
    }
  },
  components: {},
  data() {
    return {
      article: null,
      hide: false
    }
  },
  watch: {},
  mounted() {},
  methods: {
    hide_modal(show) {
      console.log(show)
      this.hide = show
    }
  }
}
</script>

<template>
  <div v-if="role">
    <Tbtn v-tooltip="'Create a new article'" pad="4" onclick="create_modal.showModal()">
      <div class="flex items-center gap-2 p-2 lg:p-0">
        <Icon class="text-4xl lg:text-2xl" icon="streamline:add-1-solid" />
        <span class="hidden lg:block">Create new article</span>
      </div>
    </Tbtn>
    <dialog id="create_modal" :class="hide ? 'hidden' : ''" class="modal">
      <div class="bg-white text-neutral-800 max-w-7xl modal-box rounded-3xl">
        <h3 class="text-3xl font-bold">New Article</h3>
        <div class="text-end text-neutral-600"></div>
        <EditArticle @loading="hide_modal" :role="role"></EditArticle>
      </div>
    </dialog>
  </div>
</template>

<style scoped></style>
