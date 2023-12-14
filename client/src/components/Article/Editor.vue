<script>
import { QuillEditor } from '@vueup/vue-quill'
import imageCompression from 'browser-image-compression'
import { computed } from 'vue'
import '@vueup/vue-quill/dist/vue-quill.snow.css'
export default {
  name: 'Edit Article',
  emits: ['loading'],
  props: {
    newArticle: {
      type: Boolean,
      default: true
    },
    toeditArticle: {
      type: Number,
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
      image_change: null,
      image_change_id: null,
      article: {
        id: null,
        title: null,
        content: null,
        image: {
          filename: null,
          ext: null,
          chunks: null,
          img: null
        },
        company: null,
        link: null,
        date: null
      },
      companies: null,
      original_img: null
    }
  },
  watch: {},
  mounted() {
    this.checkType()
    this.getCompanies()
    if (this.toeditArticle) {
      this.get_article()
    }
  },
  methods: {
    get_article() {
      this.$api.post('/get/article', { id: this.toeditArticle }).then((res) => {
        let results = res.data
        this.article.id = results.id
        this.article.title = results.title
        this.article.content = results.content
        this.image_change = results.img.preview_link
        this.image_change_id = results.img.id
        this.article.company = results.company
        this.article.link = results.link
        this.article.date = results.date
      })
    },
    checkType() {
      if (this.newArticle) {
        this.article = {
          id: null,
          title: null,
          content: null,
          image: {
            filename: null,
            ext: null,
            chunks: null,
            img: null
          },
          company: null,
          link: null,
          date: null
        }
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
        this.companies = res.data.companies
      })
    },

    fileselect(ev) {
      const file = ev.target.files[0]
      if (file) {
        this.original_img = file

        const options = {
          maxSizeMB: 1,
          maxWidth: 1920,
          useWebWorkers: true
        }
        const compressImage = async () => {
          try {
            let compressedFile = await imageCompression(file, options)
            this.article.image.filename = file.name
            this.article.image.ext = file.name.split('.').pop()
            this.article.image.img = compressedFile
            this.original_img = URL.createObjectURL(compressedFile)
          } catch (error) {
            console.error(error)
          }
        }

        compressImage()
      }
      this.article.image = {
        filename: null,
        ext: null,
        chunks: null,
        img: null
      }
    },
    async updateArticle(publish) {
      this.$emit('loading', true)
      let proceed = false
      let count = 0
      let img_id = null
      if (this.article.image.filename) {
        this.article.image.chunks = this.$zoro.slice(this.article.image.img)
        this.$notify.Loading.pulse('Uploading image')

        for await (let item of this.article.image.chunks) {
          count++
          let go = new FormData()

          go.append('file', item)
          go.append('filename', this.article.image.filename)
          go.append('ext', this.article.image.ext)
          let last = false
          if (count == this.article.image.chunks.length) {
            last = true
          }
          go.append('is_last', last)
          await this.$api
            .post('create/image', go)
            .then((res) => {
              if (last) {
                if (res.data.message == 'success') {
                  proceed = true
                  img_id = res.data.id
                  this.$notify.Notify.success('Successfully uploaded image')
                  this.$notify.Loading.change('Saving article...')
                }
              }
            })
            .catch((err) => {
              console.log(err)
            })
        }
      } else {
        proceed = true
        this.$notify.Loading.pulse('Saving changes')
      }
      let art_id = this.article.id
      if (proceed) {
        this.article.image_id = img_id ? img_id : this.image_change_id
        await this.$api
          .post('update/article', this.article)
          .then((res) => {
            if (res.data.message == 'success') {
              proceed = true
              art_id = res.data.id
              this.$notify.Notify.success('Successfully saved article')
            }
          })
          .catch((err) => {
            proceed = false
            console.log(err)
          })
      }
      if (proceed && publish) {
        let go = {
          id: art_id
        }
        this.$notify.Loading.change('Publishing article...')
        await this.$api.post('publish/article', go).then((res) => {
          if (res.data.message == 'success') {
            this.$notify.Notify.success('Successfully published')
          }
        })
      }
      this.$notify.Loading.remove()
      setTimeout(() => {
        this.$emit('loading', false)
      }, 800)
      if (!proceed) {
        this.$notify.Notify.failure('Something went wrong')
      } else {
        this.original_img = null
        this.article = {
          id: null,
          title: null,
          content: null,
          image: {
            filename: null,
            ext: null,
            chunks: null,
            img: null
          },
          company: null,
          link: null,
          date: null
        }
        this.get_article()
      }
    },
    async saveArticle(publish) {
      this.$emit('loading', true)
      this.$notify.Loading.pulse('Uploading image')
      this.article.image.chunks = this.$zoro.slice(this.article.image.img)
      let count = 0
      let proceed = false
      let img_id = null
      for await (let item of this.article.image.chunks) {
        count++
        let go = new FormData()

        go.append('file', item)
        go.append('filename', this.article.image.filename)
        go.append('ext', this.article.image.ext)
        let last = false
        if (count == this.article.image.chunks.length) {
          last = true
        }
        go.append('is_last', last)
        await this.$api
          .post('create/image', go)
          .then((res) => {
            if (last) {
              if (res.data.message == 'success') {
                proceed = true
                img_id = res.data.id
                this.$notify.Notify.success('Successfully uploaded image')
                this.$notify.Loading.change('Saving article...')
              }
            }
          })
          .catch((err) => {
            console.log(err)
          })
      }
      let art_id = null
      if (proceed) {
        this.article.image_id = img_id
        await this.$api
          .post('create/article', this.article)
          .then((res) => {
            if (res.data.message == 'success') {
              proceed = true
              art_id = res.data.id
              this.$notify.Notify.success('Successfully saved article')
            }
          })
          .catch((err) => {
            proceed = false
            console.log(err)
          })
      }
      if (proceed && publish) {
        let go = {
          id: art_id
        }
        this.$notify.Loading.change('Publishing article...')
        await this.$api.post('publish/article', go).then((res) => {
          if (res.data.message == 'success') {
            this.$notify.Notify.success('Successfully published')
          }
        })
      }
      this.$notify.Loading.remove()
      setTimeout(() => {
        this.$emit('loading', false)
      }, 800)
      if (!proceed) {
        this.$notify.Notify.failure('Something went wrong')
      } else {
        this.original_img = null
        this.article = {
          id: null,
          title: null,
          content: null,
          image: {
            filename: null,
            ext: null,
            chunks: null,
            img: null
          },
          company: null,
          link: null,
          date: null
        }
      }
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
      if (!this.image_change) {
        if (
          this.article.title &&
          this.article.content &&
          this.original_img &&
          this.article.image.img &&
          this.article.company &&
          this.article.link &&
          this.article.date
        ) {
          return true
        }
        return false
      } else {
        if (
          this.article.title &&
          this.article.content &&
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
                    v-if="companies"
                    v-model="article.company"
                    class="w-full bg-transparent select select-bordered"
                  >
                    <option :value="null" disabled selected>Select company</option>
                    <option
                      v-for="company in companies"
                      :value="company.id"
                      v-bind:key="company.id"
                    >
                      {{ company.name }}
                    </option>
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
                    <span v-if="!original_img" class="text-rose-500 label-text-alt">Required</span>
                  </div>
                  <input
                    @change="fileselect"
                    type="file"
                    accept="image/*"
                    class="w-full bg-transparent file-input-bordered file-input"
                  />
                </label>
                <div class="flex justify-center p-3" v-if="article.image.filename">
                  <img :src="original_img" class="object-contain rounded-3xl h-60 w-60" />
                </div>
                <div class="flex justify-center p-3" v-if="!article.image.filename && image_change">
                  <img :src="image_change" class="object-contain rounded-3xl h-60 w-60" />
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
        <div v-if="showbuttons">
          <div class="flex gap-4" v-if="toeditArticle">
            <Tbtn
              @click="updateArticle(true)"
              v-if="role == 'editor'"
              pad="2"
              bg="emerald"
              :selected="true"
              v-tooltip="'Save and publish article'"
            >
              <Icon class="text-2xl" icon="material-symbols:publish" />Save and Publish
            </Tbtn>
            <Tbtn @click="updateArticle(false)" pad="2" bg="sky" :selected="true"
              ><Icon class="text-2xl" icon="ic:baseline-save-as" /> Save
            </Tbtn>
          </div>
          <div v-else class="flex gap-4">
            <Tbtn
              @click="saveArticle(true)"
              v-if="role == 'editor'"
              pad="2"
              bg="emerald"
              :selected="true"
              v-tooltip="'Save and publish article'"
            >
              <Icon class="text-2xl" icon="material-symbols:publish" />Publish
            </Tbtn>
            <Tbtn @click="saveArticle(false)" pad="2" bg="sky" :selected="true"
              ><Icon class="text-2xl" icon="ic:baseline-save-as" /> Save
            </Tbtn>
          </div>
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
