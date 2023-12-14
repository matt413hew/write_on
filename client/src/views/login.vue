<script>
export default {
  name: 'Login',
  emits: [],
  props: {},
  components: {},
  data() {
    return {
      user: {
        username: null,
        password: null
      },
      errors: null
    }
  },
  watch: {},
  mounted() {},
  methods: {
    async login() {
      this.$notify.Loading.pulse('Authenticating...')
      this.errors = null
      await this.$main
        .login(this.user)
        .then((res) => {
          console.log(res)
          if (res == 'success') {
            this.$router.push({
              name: 'Default layout'
            })
            this.$notify.Notify.success('Welcome back!')
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
      this.$notify.Loading.remove()
    }
  }
}
</script>
<template>
  <div class="flex items-center justify-center w-screen h-screen bg-neutral-100">
    <div>
      <div class="flex flex-col gap-2 text-center text-neutral-800">
        <div class="text-6xl font-light">Welcome to</div>
        <div
          class="flex items-center justify-center pb-4 text-8xl font-extralight border-y-2 border-neutral-500"
        >
          Write_on|
        </div>
        <div class="text-3xl font-medium">A simple writer/editor dashboard</div>
      </div>
      <div
        v-if="errors"
        class="flex flex-col gap-2 p-3 mt-5 text-center rounded-3xl bg-rose-400 text-neutral-900"
      >
        <div v-for="err in errors" v-bind:key="err[0]">{{ err[0] }}</div>
      </div>
      <div class="flex flex-col items-center gap-2 p-6">
        <input
          v-model="user.username"
          type="text"
          placeholder="Username"
          class="w-full input text-neutral-900 bg-neutral-50 input-bordered"
        />
        <input
          v-model="user.password"
          type="password"
          placeholder="Password "
          class="w-full input text-neutral-900 bg-neutral-50 input-bordered"
        />
        <Tbtn @click="login()">
          <span class="text-xl">
            <div class="flex items-center justify-center gap-1 px-3 py-1">
              Login <Icon class="text-2xl" icon="tabler:login-2" />
            </div>
          </span>
        </Tbtn>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
