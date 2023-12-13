<script>
export default {
  name: 'Home',
  emits: [],
  props: {},
  components: {},
  data() {
    return {
      tab: 'edit',
      articles: [
        {
          title: 'Sample article',
          image:
            'https://valorantfiles.com/images/sprays/22ae8535-40b6-95a3-c5b1-98a184b8909f/animation.gif',
          link: 'Sample link',
          date: new Date(),
          writer: 'Monkey D. Luffy',
          editor: 'Monkey D. Garp'
        }
      ]
    }
  },
  watch: {},
  async mounted() {
    let x = await this.$main.test()
    console.log(x)
  },
  methods: {}
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
              class="pb-4 lg:text-5xl md:text-4xl sm:text-3xl text-2xl font-semibold text-center text-neutral-700"
            >
              Articles for editing
            </div>

            <div class="overflow-x-auto rounded-3xl">
              <table class="table table-lg rounded-3xl bg-neutral-200">
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
                  <tr v-for="article in articles" v-bind:key="article.title" class="border-none">
                    <td>
                      <div class="avatar">
                        <div class="w-24 rounded">
                          <img class="hover:scale-150" :src="article.image" />
                        </div>
                      </div>
                    </td>
                    <td>{{ article.title }}</td>
                    <td>{{ article.link }}</td>
                    <td>
                      {{ $dayjs(article.date).format('MMMM D, YYYY') }}
                    </td>
                    <td>{{ article.writer }}</td>
                    <td>{{ article.editor }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div v-if="tab == 'publish'">
            <!-- <table class="w-full table-auto">
              <thead>
                <tr>
                  <th>Song</th>
                  <th>Artist</th>
                  <th>Year</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>The Sliding Mr. Bones (Next Stop, Pottersville)</td>
                  <td>Malcolm Lockyer</td>
                  <td>1961</td>
                </tr>
                <tr>
                  <td>Witchy Woman</td>
                  <td>The Eagles</td>
                  <td>1972</td>
                </tr>
                <tr>
                  <td>Shining Star</td>
                  <td>Earth, Wind, and Fire</td>
                  <td>1975</td>
                </tr>
              </tbody>
            </table> -->
          </div>
        </transition-group>
      </div>
    </PageBody>
  </Page>
</template>

<style scoped></style>
