import { defineStore } from "pinia";
import { api } from "@/axios";

const useMainStore = defineStore("user", {
  state: () => ({
    user: null,
    token:null,
  }),
  getters:{
    getUser(state) {
      return state.user;
    },
    getAccessToken(state) {
      return state.token;
    },
    isLoggedin(state){
      if (state.user && state.token) {
        return true;
      }
      this.resetState();
      return false;
    },
    isEditor(state){
      if (state.user.role == 'editor') {
        return true
      }
      return false
    },
    isWriter(state){
      if (state.user.role == 'writer') {
        return true
      }
      return false
    },
  },
  actions: {
    async login(user){
        return await api.post('/login',user).then((res)=>{
          this.token = `${res.data.token_type} ${res.data.token}` 
          this.user = res.data.user
          this.user.role = res.data.role
          return res.data.message;
        }).catch((err)=>{
          if (err.response?.data?.errors) {
            return err.response?.data?.errors
          }else{
            return err 
          }
        })
    },
    async resetState(){
      this.user = null;
      this.token = null;
    },
    async logout(){
        return await api.post('/logout').then((res)=>{
          if (res.data.message == 'success') {
            this.resetState();
            return 'success'
          }
        }).catch((err)=>{
         console.log(err)
        })
    },
    
  },
});
export {
    useMainStore
};