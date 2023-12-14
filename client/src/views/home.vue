<script>
export default {
  name: 'Home',
  emits: [],
  props: {},
  components: {},
  data() {
    return {
      tab: 'edit',
      articles: null,
      published: null
    }
  },
  watch: {
    tab(val) {
      if (val == 'edit') {
        this.getForEdit()
      }
      this.getPublished()
    }
  },
  async mounted() {
    this.getForEdit()
  },
  methods: {
    async getForEdit(page = 1) {
      if (this.articles) {
        this.articles.data = null
      }
      await this.$api
        .get('/get/for-edit', {
          params: {
            page: page
          }
        })
        .then((res) => {
          this.articles = res.data
        })
    },
    async getPublished(page = 1) {
      if (this.published) {
        this.published.data = null
      }
      await this.$api
        .get('get/published', {
          params: {
            page: page
          }
        })
        .then((res) => {
          this.published = res.data
        })
    }
  }
}
</script>

<template>
  <Page>
    <PageHead> Dashboard </PageHead>
    <PageBody>
      <div class="flex items-center gap-2">
        <div class="w-full">
          <Tbtn stretch @click="tab = 'edit'" :selected="tab == 'edit'">
            <span class="text-2xl"> For Edit </span>
          </Tbtn>
        </div>
        <div class="w-full">
          <Tbtn stretch @click="tab = 'publish'" :selected="tab == 'publish'">
            <span class="text-2xl"> Published </span>
          </Tbtn>
        </div>
      </div>
      <div>
        <transition-group
          enter-from-class="opacity-0 "
          enter-to-class="opacity-100 "
          enter-active-class="ease[cubic-bezier(.26,.61,0,1.12)] duration-[0.3s] delay-150"
        >
          <div v-if="tab == 'edit'" class="pt-7">
            <div
              class="pb-4 text-2xl font-semibold text-center lg:text-5xl md:text-4xl sm:text-3xl text-neutral-700"
            >
              Articles for editing
            </div>

            <div class="overflow-x-auto rounded-3xl">
              <table
                v-if="articles"
                class="table table-lg rounded-3xl min-h-[50vh] max-h-[60vh] overflow-auto bg-neutral-200"
              >
                <thead>
                  <tr
                    class="text-base underline border-b-0.5 border-b-neutral-500 text-neutral-800"
                  >
                    <th>Image</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Date</th>
                    <th>Writer</th>
                  </tr>
                </thead>
                <tbody class="rounded-b-sm text-neutral-800">
                  <tr
                    v-for="article in articles.data"
                    v-bind:key="article.title"
                    class="border-none"
                  >
                    <td>
                      <div class="flex justify-center w-100">
                        <div class="w-56 rounded-xl">
                          <img class="object-contain" :src="article.img.preview_link" />
                        </div>
                      </div>
                    </td>
                    <td>{{ article.title }}</td>
                    <td>{{ article.link }}</td>
                    <td>
                      {{ $dayjs(article.date).format('MMMM D, YYYY') }}
                    </td>
                    <td>{{ article.wrote.first_name + ' ' + article.wrote.last_name }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="flex items-center justify-center w-full">
              <Paginate
                v-if="articles"
                :limit="1"
                :item-classes="[
                  'bg-neutral-300 text-neutral-800 rounded-2xl m-1 lg:m-2 px-3 lg:px-5'
                ]"
                :active-classes="['bg-neutral-800 px-3 lg:px-5 rounded-2xl m-1 lg:m-2']"
                :data="articles"
                @pagination-change-page="getForEdit"
              />
            </div>
          </div>
          <div v-if="tab == 'publish'" class="pt-7">
            <div
              class="pb-4 text-2xl font-semibold text-center lg:text-5xl md:text-4xl sm:text-3xl text-neutral-700"
            >
              Published articles
            </div>

            <div class="overflow-x-auto rounded-3xl">
              <table
                v-if="articles"
                class="table table-lg rounded-3xl min-h-[50vh] max-h-[60vh] overflow-auto bg-neutral-200"
              >
                <thead>
                  <tr
                    class="text-base underline border-b-0.5 border-b-neutral-500 text-neutral-800"
                  >
                    <th>Image</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Date</th>
                    <th>Writer</th>
                    <th>Editor</th>
                  </tr>
                </thead>
                <tbody class="rounded-b-sm text-neutral-800">
                  <tr
                    v-for="article in published.data"
                    v-bind:key="article.title"
                    class="border-none"
                  >
                    <td>
                      <div class="flex justify-center w-100">
                        <div class="w-56 rounded-xl">
                          <img class="object-contain" :src="article.img.preview_link" />
                        </div>
                      </div>
                    </td>
                    <td>{{ article.title }}</td>
                    <td>{{ article.link }}</td>
                    <td>
                      {{ $dayjs(article.date).format('MMMM D, YYYY') }}
                    </td>
                    <td>{{ article.wrote.first_name + ' ' + article.wrote.last_name }}</td>
                    <td>{{ article.edited.first_name + ' ' + article.edited.last_name }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="flex items-center justify-center w-full">
              <Paginate
                v-if="published"
                :limit="1"
                :item-classes="[
                  'bg-neutral-300 text-neutral-800 rounded-2xl m-1 lg:m-2 px-3 lg:px-5'
                ]"
                :active-classes="['bg-neutral-800 px-3 lg:px-5 rounded-2xl m-1 lg:m-2']"
                :data="published"
                @pagination-change-page="getPublished"
              />
            </div>
          </div>
        </transition-group>
      </div>
    </PageBody>
  </Page>
</template>

<style scoped></style>
