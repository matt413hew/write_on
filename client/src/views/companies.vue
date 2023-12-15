<script>
export default {
  name: 'Companies',
  emits: [],
  props: {},
  components: {},
  data() {
    return {
      companies: null,
      company: {
        logo: null,
        name: null
      },
      show_modal: true
    }
  },
  watch: {},
  mounted() {
    this.getCompanies()
  },
  methods: {
    getCompanies() {
      this.$api.post('all/companies').then((res) => {
        this.companies = res.data.companies
      })
    },
    async saveCompany() {
      this.show_modal = false
      this.$notify.Loading.pulse('Saving company...')
      await this.$api
        .post('create/company', this.company)
        .then((res) => {
          if (res.data.message == 'success') {
            this.$notify.Notify.success('Successfully saved ')
          }
        })
        .catch((err) => {
          console.log(err)
        })
      this.company = {
        logo: null,
        name: null
      }
      this.getCompanies()
      this.$notify.Loading.remove()
      this.show_modal = true
    },
    async activate(id) {
      this.show_modal = false
      let go = {
        id: id
      }
      this.$notify.Loading.pulse('Saving change...')
      await this.$api
        .post('activate/company', go)
        .then((res) => {
          if (res.data.message == 'success') {
            this.$notify.Notify.success('Successfully saved changes')
          }
        })
        .catch((err) => {
          console.log(err)
        })
      this.getCompanies()
      this.$notify.Loading.remove()
      this.show_modal = true
    }
  },
  computed: {
    isValidLink() {
      if (this.company.logo) {
        let str = this.company.logo
        const pattern = new RegExp(
          '^(https?:\\/\\/)?((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|(\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}))(:\\d{2,5})?(/[^\\s]*)?$',
          'i'
        )
        return !!pattern.test(str)
      }
      return false
    }
  }
}
</script>
<template>
  <Page>
    <PageHead>Companies</PageHead>
    <PageBody>
      <div v-if="companies" class="p-2">
        <div class="grid grid-cols-1 gap-4 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2">
          <div
            v-for="comp in companies"
            v-bind:key="comp.id"
            class="flex items-center justify-between gap-3 p-5 rounded-xl text-neutral-800"
            :class="comp.status ? 'bg-neutral-200' : 'bg-neutral-400'"
          >
            <div class="flex items-center justify-center gap-2">
              <img class="object-contain w-20 h-20" :src="comp.logo" alt="" />
              {{ comp.name }}
            </div>
            <div>
              <Tbtn v-if="!comp.status" @click="activate(comp.id)"> Activate </Tbtn>
              <Tbtn v-else @click="activate(comp.id)"> Deactivate </Tbtn>
            </div>
          </div>
          <div
            class="flex items-center justify-center w-full gap-3 p-5 rounded-xl text-neutral-800 bg-neutral-200"
          >
            <Tbtn onclick="add_modal.showModal()" v-tooltip="'Add company'"
              ><Icon class="text-2xl" icon="gg:add" />
            </Tbtn>
            <dialog :class="!show_modal ? 'hidden' : ''" id="add_modal" class="modal">
              <div class="max-w-3xl modal-box bg-neutral-50">
                <h3 class="text-3xl font-bold">Add company</h3>
                <div class="grid grid-cols-1 gap-3 p-3 lg:grid-cols-2">
                  <label class="form-control">
                    <div class="label">
                      <span class="text-lg label-text text-neutral-700">Company name</span>

                      <span v-if="!company.name" class="text-rose-500 label-text-alt"
                        >Required</span
                      >
                    </div>
                    <input
                      v-model="company.name"
                      type="text"
                      placeholder="Type name here"
                      class="w-full bg-transparent input input-bordered"
                    />
                  </label>
                  <label class="form-control">
                    <div class="label">
                      <span class="text-lg label-text text-neutral-700">Logo link</span>
                      <span
                        v-if="company?.logo && !isValidLink"
                        class="text-rose-500 label-text-alt"
                        >Must be a valid link</span
                      >
                      <span v-if="!company.logo" class="text-rose-500 label-text-alt"
                        >Required</span
                      >
                    </div>
                    <input
                      v-model="company.logo"
                      type="text"
                      placeholder="Type link here"
                      class="w-full bg-transparent input input-bordered"
                      :class="!isValidLink ? 'text-rose-800' : ''"
                    />
                  </label>
                </div>
                <div class="modal-action">
                  <div class="flex gap-2">
                    <Tbtn
                      v-if="company.name && company.logo"
                      @click="saveCompany()"
                      pad="2"
                      bg="sky"
                      :selected="true"
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
              </div>
            </dialog>
          </div>
        </div>
      </div>
    </PageBody>
  </Page>
</template>

<style scoped></style>
