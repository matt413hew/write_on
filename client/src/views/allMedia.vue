<script>
export default {
  name: 'AllMedia',
  emits: [],
  props: {},
  components: {},
  data() {
    return {
      articles: null
    }
  },
  watch: {},
  mounted() {
    this.getAll()
  },
  methods: {
    async publish(id) {
      this.$notify.Loading.pulse('Uploading image')
      let go = {
        id: id
      }
      await this.$api.post('publish/article', go).then((res) => {
        if (res.data.message == 'success') {
          this.$notify.Notify.success('Successfully published')
        }
      })
      this.getAll()
      this.$notify.Loading.remove()
    },
    async getAll(page = 1) {
      if (this.articles) {
        this.articles.data = null
      }
      await this.$api
        .get('get/articles', {
          params: {
            page: page
          }
        })
        .then((res) => {
          this.articles = res.data
        })
    }
  }
}
</script>
<template>
  <Page>
    <PageHead>All media</PageHead>
    <PageBody>
      <div class="overflow-x-auto rounded-3xl">
        <table
          v-if="articles"
          class="table table-lg rounded-3xl min-h-[50vh] max-h-[60vh] overflow-auto bg-neutral-200"
        >
          <thead>
            <tr class="text-base underline border-b-0.5 border-b-neutral-500 text-neutral-800">
              <th>Image</th>
              <th>Title</th>
              <th>Link</th>
              <th>Date</th>
              <th>Writer</th>
              <th>Editor</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody class="rounded-b-sm text-neutral-800">
            <tr v-for="article in articles.data" v-bind:key="article.title" class="border-none">
              <td>
                <div class="flex justify-center w-100">
                  <div class="flex w-56 h-56 rounded-xl">
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
              <td>
                <span v-if="article.edited">
                  {{ article.edited.first_name + ' ' + article.edited.last_name }}
                </span>
                <span v-else> N/A </span>
              </td>
              <td>
                {{ article.status_name.name }}
              </td>
              <td>
                <div class="flex gap-2">
                  <div
                    @click="publish(article.id)"
                    v-if="$main.isEditor && article.status_name.name != 'Published'"
                    class="btn bg-neutral-50 !rounded-2xl text-neutral-800 border-none hover:bg-neutral-200"
                  >
                    Publish
                  </div>
                  <UpdateArticle :role="$main.getUser.role" :article="article.id"></UpdateArticle>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="flex items-center justify-center w-full">
          <Paginate
            v-if="articles"
            :limit="1"
            :item-classes="['bg-neutral-300 text-neutral-800 rounded-2xl m-1 lg:m-2 px-3 lg:px-5']"
            :active-classes="['bg-neutral-800 px-3 lg:px-5 rounded-2xl m-1 lg:m-2']"
            :data="articles"
            @pagination-change-page="getAll"
          />
        </div>
      </div>
    </PageBody>
  </Page>
</template>
<style scoped></style>
