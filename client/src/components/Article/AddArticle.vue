<template>
  <div>
    <Tbtn v-tooltip="'Create a new article'" pad="4" onclick="create_modal.showModal()"
      ><Icon icon="streamline:add-1-solid"
    /></Tbtn>
    <dialog id="create_modal" :open="newA" class="modal">
      <div class="bg-white text-neutral-800 max-w-7xl modal-box rounded-3xl">
        <h3 class="text-3xl font-bold">New Article</h3>
        <div class="text-end text-neutral-600">
          <p class="py-4">Press ESC key or click the button below to close</p>
        </div>
        <div class="p-4 rounded-3xl bg-neutral-50">
          <div class="flex flex-col gap-2">
            <div>
              <div class="flex items-center gap-2">
                <!-- title -->
                <div class="flex flex-col w-full gap-0">
                  <label class="form-control">
                    <div class="label">
                      <span class="text-lg label-text text-neutral-700">Title</span>
                    </div>
                    <input
                      type="text"
                      placeholder="Type title here"
                      class="w-full bg-transparent input input-bordered"
                    />
                  </label>
                  <label class="form-control">
                    <div class="label">
                      <span class="text-lg label-text text-neutral-700">Company</span>
                    </div>
                    <select
                      v-model="article.company"
                      class="w-full bg-transparent select select-bordered"
                    >
                      <option :value="null" disabled selected>Select company</option>
                      <option value="1">Han Solo</option>
                      <option value="2">Greedo</option>
                    </select>
                  </label>
                  <label class="form-control">
                    <div class="label">
                      <span class="text-lg label-text text-neutral-700">Link</span>
                    </div>
                    <input
                      type="text"
                      placeholder="Type link here"
                      class="w-full bg-transparent input input-bordered"
                    />
                  </label>
                  <label class="form-control">
                    <div class="label">
                      <span class="text-lg label-text text-neutral-700">Date</span>
                    </div>
                    <input
                      type="text"
                      placeholder="Type title here"
                      class="w-full bg-transparent input input-bordered"
                    />
                  </label>
                </div>
                <!-- img -->
                <div class="w-full">
                  <label class="form-control">
                    <div class="label">
                      <span class="text-lg label-text text-neutral-700">Image</span>
                    </div>
                    <input
                      @change="handleImageChange"
                      type="file"
                      accept="image/*"
                      class="w-full bg-transparent file-input-bordered file-input"
                    />
                  </label>
                  <div class="flex justify-center p-3" v-if="article?.image">
                    <img :src="article.image" class="object-contain rounded-3xl h-60 w-60" />
                  </div>
                </div>
              </div>
            </div>
            <!-- body -->
            <label class="w-full form-control">
              <div class="label">
                <span class="text-lg label-text text-neutral-700">Body</span>
              </div>
              <QuillEditor
                contentType="html"
                toolbar="full"
                placeholder="Type body here..."
                v-model:content="article.content"
              ></QuillEditor>
            </label>
          </div>
        </div>
        <div class="flex gap-2 modal-action">
          <Tbtn pad="2" bg="emerald" :selected="true" v-tooltip="'Save and publish article'">
            <Icon class="text-2xl" icon="material-symbols:publish" />Publish
          </Tbtn>
          <Tbtn pad="2" bg="sky" :selected="true"
            ><Icon class="text-2xl" icon="ic:baseline-save-as" /> Save
          </Tbtn>
          <form method="dialog">
            <button>
              <Tbtn pad="2" bg="rose" :selected="true"
                ><Icon class="text-2xl" icon="icomoon-free:cancel-circle" /> Cancel
              </Tbtn>
            </button>
          </form>
        </div>
      </div>
    </dialog>
  </div>
</template>

<script>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
export default {
  name: 'Add Article',
  emits: [],
  props: {},
  components: {
    QuillEditor
  },
  data() {
    return {
      article: {
        content: null,
        image: null,
        company: null
      }
    }
  },
  watch: {},
  mounted() {},
  methods: {
    handleImageChange(event) {
      const file = event.target.files[0]
      if (!file) this.article.image = null
      const reader = new FileReader()
      reader.onload = (e) => {
        this.article.image = e.target.result
      }
      reader.readAsDataURL(file)
    }
  }
}
</script>
<style scoped></style>
