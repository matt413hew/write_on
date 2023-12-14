<script>
import { QuillEditor } from '@vueup/vue-quill'
import imageCompression from 'browser-image-compression'
import { computed } from 'vue'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
export default {
  name: 'Edit Article',
  emits: [],
  props: {
    newArticle: {
      type: Boolean,
      default: true
    },
    editArticle: {
      type: Object,
      default: null
    },
    role: {
      type: String,
      default: null
    }
  },
  components: {
    QuillEditor
  },
  data() {
    return {
      article: {
        id: null,
        title: null,
        content: null,
        image: null,
        company: null,
        link: null,
        date: null
      }
    }
  },
  watch: {},
  mounted() {
    this.checkType()
    this.getCompanies()
  },
  methods: {
    checkType() {
      if (this.newArticle) {
        this.article = {
          id: null,
          content: null,
          image: null,
          company: null
        }
      } else {
      }
    },
    handleImageChange(event) {
      const file = event.target.files[0]
      if (!file) this.article.image = null
      const reader = new FileReader()
      reader.onload = (e) => {
        this.article.image = e.target.result
      }
      reader.readAsDataURL(file)
    },
    getCompanies() {
      this.$api.post('/companies').then((res) => {
        console.log(res)
      })
    }
  },
  computed: {
    isValidLink() {
      if (this.article?.link) {
        let str = this.article.link
        const pattern = new RegExp(
          '^(https?:\\/\\/)?((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|(\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}))(:\\d{2,5})?(/[^\\s]*)?$',
          'i'
        )
        return !!pattern.test(str)
      }
      return false
    },
    isContent() {
      if (this.article?.content) {
        let tags = this.article.content.replace(/<[^>]*>/g, '')
        tags = tags.replace(/\s+/g, '')
        if (!tags) {
          return false
        }
        return true
      }
      return false
    },
    showbuttons() {
      if (
        this.article.title &&
        this.article.content &&
        this.article.image &&
        this.article.company &&
        this.article.link &&
        this.article.date
      ) {
        return true
      }
      return false
    }
  }
}
</script>
<template>
  <div>
    <div class="bg-white text-neutral-800 max-w-7xl rounded-3xl">
      <div class="p-4 rounded-3xl bg-neutral-50">
        <div class="flex flex-col w-full gap-2">
          <div>
            <div class="grid w-full gap-2 lg:grid-cols-2">
              <!-- title -->
              <div class="flex flex-col w-full gap-0">
                <label class="form-control">
                  <div class="label">
                    <span class="text-lg label-text text-neutral-700">Title</span>
                    <span v-if="!article.title" class="text-rose-500 label-text-alt">Required</span>
                  </div>
                  <input
                    v-model="article.title"
                    type="text"
                    placeholder="Type title here"
                    class="w-full bg-transparent input input-bordered"
                  />
                </label>
                <label class="form-control">
                  <div class="label">
                    <span class="text-lg label-text text-neutral-700">Company</span>
                    <span v-if="!article.company" class="text-rose-500 label-text-alt"
                      >Required</span
                    >
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
                    <span v-if="article.link && !isValidLink" class="text-rose-500 label-text-alt"
                      >Must be a valid link</span
                    >
                    <span v-if="!article.link" class="text-rose-500 label-text-alt">Required</span>
                  </div>
                  <input
                    v-model="article.link"
                    type="text"
                    placeholder="Type link here"
                    class="w-full bg-transparent input input-bordered"
                    :class="!isValidLink ? 'text-rose-800' : ''"
                  />
                </label>
                <label class="form-control">
                  <div class="label">
                    <span class="text-lg label-text text-neutral-700">Date</span>
                    <span v-if="!article.date" class="text-rose-500 label-text-alt">Required</span>
                  </div>
                  <VueDatePicker
                    v-model="article.date"
                    :max-date="new Date()"
                    :enable-time-picker="false"
                    auto-apply
                  ></VueDatePicker>
                  <!-- <input
                    type="text"
                    placeholder="Type title here"
                    class="w-full bg-transparent input input-bordered"
                  /> -->
                </label>
              </div>
              <!-- img -->
              <div class="w-full">
                <label class="form-control">
                  <div class="label">
                    <span class="text-lg label-text text-neutral-700">Image</span>
                    <span v-if="!article.image" class="text-rose-500 label-text-alt">Required</span>
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
              <span class="text-lg label-text text-neutral-700">Content</span>
              <span v-if="!isContent" class="text-rose-500 label-text-alt">Required</span>
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
        <div v-if="showbuttons" class="flex gap-4">
          <Tbtn
            v-if="role == 'editor'"
            pad="2"
            bg="emerald"
            :selected="true"
            v-tooltip="'Save and publish article'"
          >
            <Icon class="text-2xl" icon="material-symbols:publish" />Publish
          </Tbtn>
          <Tbtn pad="2" bg="sky" :selected="true"
            ><Icon class="text-2xl" icon="ic:baseline-save-as" /> Save
          </Tbtn>
        </div>
        <form method="dialog">
          <button>
            <Tbtn pad="2" bg="rose" :selected="true"
              ><Icon class="text-2xl" icon="icomoon-free:cancel-circle" /> Cancel
            </Tbtn>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
