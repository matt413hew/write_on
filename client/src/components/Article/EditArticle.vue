<script>
export default {
  name: 'Edit Article',
  emits: [],
  props: {
    role: {
      type: String,
      default: null
    },
    article: {
      type: Number,
      default: null
    }
  },
  components: {},
  data() {
    return {
      hide: false
    }
  },
  watch: {},
  mounted() {},
  methods: {
    hide_modal(show) {
      this.hide = show
    }
  }
}
</script>

<template>
  <div v-if="role" class="z-[50]">
    <div
      :onclick="'edit_modal' + article + '.showModal()'"
      class="btn bg-neutral-50 !rounded-2xl text-neutral-800 border-none hover:bg-neutral-200"
    >
      Edit
    </div>
    <dialog :id="'edit_modal' + article" :class="hide ? 'hidden' : ''" class="modal">
      <div class="bg-white text-neutral-800 max-w-7xl modal-box rounded-3xl">
        <h3 class="text-3xl font-bold">New Article</h3>
        <div class="text-end text-neutral-600"></div>
        <EditArticle :toeditArticle="article" @loading="hide_modal" :role="role"></EditArticle>
      </div>
    </dialog>
  </div>
</template>

<style scoped></style>
