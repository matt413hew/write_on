<script>
export default {
  name: 'UserManagement',
  emits: [],
  props: {},
  components: {},
  data() {
    return {
      users: null,
      errors: null,
      roles: null,
      isLoading: false,
      new_user: {
        first_name: null,
        last_name: null,
        username: null,
        role: null,
        password: null,
        password_confirmation: null
      }
    }
  },
  watch: {},
  mounted() {
    this.getRoles()
    this.getUsers()
  },
  methods: {
    AvoidSpace(event) {
      var k = event ? event.which : window.event.keyCode
      if (k == 32) return false
    },
    getRoles() {
      this.$api.post('roles').then((res) => {
        this.roles = res.data
      })
    },
    getUsers(page = 1) {
      this.$api
        .get('users/all', {
          params: {
            page: page
          }
        })
        .then((res) => {
          this.users = res.data
        })
    },
    generateAvatar(name) {
      return `https://api.dicebear.com/7.x/notionists/svg?seed=${name}'`
    },
    async activateUser(id) {
      let go = {
        id: id
      }
      this.$notify.Loading.pulse('Saving change...')
      await this.$api
        .post('activate/user', go)
        .then((res) => {
          if (res.data.message == 'success') {
            this.$notify.Notify.success('Successfully saved changes')
          }
        })
        .catch((err) => {
          console.log(err)
        })
      this.getUsers()
      this.$notify.Loading.remove()
    },
    async addNew() {
      this.isLoading = true
      this.$notify.Loading.pulse('Adding')
      this.errors = null
      await this.$main
        .addUser(this.new_user)
        .then(async (res) => {
          console.log(res)
          if (res.message == 'success') {
            await this.$notify.Confirm.show(
              'Success! Save credentials before closing',
              `Username: ${this.new_user.username}    Password: ${this.new_user.password}`,
              'Okay',
              () => {}
            )
            this.new_user = {
              first_name: null,
              last_name: null,
              username: null,
              role: null,
              password: null,
              password_confirmation: null
            }

            this.$notify.Notify.success('Successfully added user')
          } else {
            if (res?.response?.data?.message) {
              this.errors = {
                creds: [res.response.data.message]
              }
            } else {
              this.errors = res.data
            }
          }
        })
        .catch((err) => {
          console.log(err)
        })
      this.isLoading = false
      this.$notify.Loading.remove()
    }
  }
}
</script>
<template>
  <Page>
    <PageHead>User Management</PageHead>
    <PageBody>
      <div class="flex justify-end p-2">
        <Tbtn
          stretched
          v-tooltip="'Add new user'"
          pad="4"
          class=""
          onclick="user_modal.showModal()"
        >
          <div class="flex items-center gap-2 p-2 lg:p-0">
            <Icon class="text-4xl lg:text-2xl" icon="streamline:add-1-solid" />
            <span class="hidden lg:block">Add user</span>
          </div>
        </Tbtn>
        <dialog :class="isLoading ? 'hidden' : ''" id="user_modal" class="modal">
          <div class="max-w-2xl bg-white text-neutral-800 modal-box rounded-3xl">
            <h3 class="text-3xl font-bold">Add user</h3>
            <div>
              <div
                v-if="errors"
                class="flex flex-col gap-2 p-3 mt-5 text-center rounded-3xl bg-rose-400 text-neutral-900"
              >
                <div v-for="err in errors" v-bind:key="err[0]">{{ err[0] }}</div>
              </div>
            </div>
            <div class="grid grid-cols-1 p-4">
              <label class="form-control">
                <div class="label">
                  <span class="text-lg label-text text-neutral-700">Username</span>

                  <span v-if="!new_user.username" class="text-rose-500 label-text-alt"
                    >Required</span
                  >
                </div>
                <input
                  v-model="new_user.username"
                  @keydown.space.prevent
                  type="text"
                  placeholder="Type username here"
                  class="w-full bg-transparent input input-bordered"
                />
              </label>
              <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
                <label class="form-control">
                  <div class="label">
                    <span class="text-lg label-text text-neutral-700">First name</span>

                    <span v-if="!new_user.first_name" class="text-rose-500 label-text-alt"
                      >Required</span
                    >
                  </div>
                  <input
                    v-model="new_user.first_name"
                    type="text"
                    placeholder="Type first name here"
                    class="w-full bg-transparent input input-bordered"
                  />
                </label>
                <label class="form-control">
                  <div class="label">
                    <span class="text-lg label-text text-neutral-700">Last name</span>

                    <span v-if="!new_user.last_name" class="text-rose-500 label-text-alt">
                      Required
                    </span>
                  </div>
                  <input
                    v-model="new_user.last_name"
                    type="text"
                    placeholder="Type last name here"
                    class="w-full bg-transparent input input-bordered"
                  />
                </label>
              </div>
              <div>
                <label class="form-control">
                  <div class="label">
                    <span class="text-lg label-text text-neutral-700">Role</span>
                    <span v-if="!new_user.role" class="text-rose-500 label-text-alt">
                      Required
                    </span>
                  </div>
                  <select v-model="new_user.role" class="w-full bg-white select select-bordered">
                    <option disabled selected>Select role</option>
                    <option v-for="role in roles" :value="role.name" v-bind:key="role.id">
                      {{ role.name }}
                    </option>
                  </select>
                </label>
              </div>
              <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
                <label class="form-control">
                  <div class="label">
                    <span class="text-lg label-text text-neutral-700">Password</span>

                    <span v-if="!new_user.password" class="text-rose-500 label-text-alt">
                      Required
                    </span>
                  </div>
                  <input
                    v-model="new_user.password"
                    type="password"
                    placeholder="Enter desired password"
                    class="w-full bg-transparent input input-bordered"
                  />
                </label>
                <label class="form-control">
                  <div class="label">
                    <span class="text-lg label-text text-neutral-700">Confirm Password</span>

                    <span
                      v-if="!new_user.password_confirmation"
                      class="text-rose-500 label-text-alt"
                    >
                      Required
                    </span>
                  </div>
                  <input
                    v-model="new_user.password_confirmation"
                    type="password"
                    placeholder="Confirm your password"
                    class="w-full bg-transparent input input-bordered"
                  />
                </label>
              </div>
            </div>
            <div class="modal-action">
              <form method="dialog">
                <button id="close_button">
                  <Tbtn @click="addNew()" pad="2" bg="sky" :selected="true"
                    ><Icon class="text-2xl" icon="ic:baseline-save-as" /> Save
                  </Tbtn>
                </button>
                <button id="close_button">
                  <Tbtn pad="2" bg="rose" :selected="true"
                    ><Icon class="text-2xl" icon="icomoon-free:cancel-circle" /> Cancel
                  </Tbtn>
                </button>
              </form>
            </div>
          </div>
        </dialog>
      </div>
      <table
        v-if="users"
        class="table table-lg rounded-3xl min-h-[50vh] max-h-[60vh] overflow-auto bg-neutral-200"
      >
        <thead>
          <tr class="text-base underline border-b-0.5 border-b-neutral-500 text-neutral-800">
            <th>Name</th>
            <th>Role/s</th>
            <th>Date added</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="rounded-b-sm text-neutral-800">
          <tr v-for="user in users.data" v-bind:key="user.id">
            <td>
              <div class="flex items-center gap-2">
                <div>
                  <img
                    class="w-24 h-24 bg-white border-4 rounded-full border-neutral-500"
                    :src="generateAvatar(user.first_name)"
                    alt=""
                    srcset=""
                  />
                </div>
                <div>
                  <div>
                    {{ user.username }}
                  </div>
                  <div>
                    {{ user.first_name + ' ' + user.last_name }}
                  </div>
                </div>
              </div>
            </td>
            <td>
              {{ user.roles[0].name }}
            </td>
            <td>
              {{ $dayjs(user.created_at).format('MMMM D, YYYY') }}
            </td>
            <td>
              <span v-if="user.active">Active</span>
              <span v-else>Deactivated</span>
            </td>
            <td>
              <Tbtn v-if="user.active" @click="activateUser(user.id)"> Deactivate </Tbtn>
              <Tbtn v-else @click="activateUser(user.id)"> Activate </Tbtn>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="flex items-center justify-center w-full 0-4">
        <Paginate
          v-if="users"
          :limit="1"
          :item-classes="['bg-neutral-300 text-neutral-800 rounded-2xl m-1 lg:m-2 px-3 lg:px-5']"
          :active-classes="['bg-neutral-800 px-3 lg:px-5 rounded-2xl m-1 lg:m-2']"
          :data="users"
          @pagination-change-page="getUsers"
        />
      </div>
    </PageBody>
  </Page>
</template>

<style scoped></style>
