import { defineStore } from "pinia";
import axios from "axios";

const useMainStore = defineStore("user", {
  state: () => ({
    user: null,
  }),

  actions: {
    async test() {
  return await axios.get('/get-message')
      .then((res) => {
        return res
        console.log(res)
      })
      .catch((error) => {
        return error
        console.log(error)
      })
    },
    async login(user){
        return await axios.post('/login',user).then((res)=>{
            return res;
        }).catch((err)=>{
            return err.response.data.errors;
        })
        
    }
  },
});
export {
    useMainStore
};