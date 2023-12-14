
import axios from "axios";
import { useMainStore } from "./stores/mainStore";
import router from './router'
import Notiflix from 'notiflix';

let options = {
  withCredentials: true,
  headers: {
    Accept: "application/json",
  },
};
const api = axios.create(options);

api.defaults.baseURL = 'http://localhost:8000/api/';
api.defaults.withCredentials = false;
let configs = null;
api.interceptors.request.use(
  (config) => {
      const auth = useMainStore()
      if (auth.isLoggedin) {
        config.headers.Authorization = auth.getAccessToken;
      }
    
    configs = config
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

api.interceptors.response.use(
  (response) => {
    return response;
  },
 async (error) => {
    const useAuth = useMainStore();

    if (error.response && error.response.status === 401) {
            useAuth.resetState();
            router.push({ name: "Login" });
    }
    if (error.response && error.response.status === 403) {
      router.push({ name: "unauthenticated" });
    }
    if (error.response && error.response.status === 404) {
      router.push({ name: "NotFound" });
    }

    let err = error.response.data.message
    if (error.response.data.errors && Object.keys(error.response.data.errors).length > 1) {
      Object.keys(error.response.data.errors).forEach(key => {
        err += error.response.data.errors[key] + '<br/>'
        Notiflix.Notify.failure(
          error.response.data.errors[key],
        );
      });

    }
    if (typeof error.response.data.message == "undefined") {
      Notiflix.Notify.failure(
        error.response.data.error,
      );
    } else {
      Notiflix.Notify.failure(
        err,
      );
    }
    return Promise.reject(error);
  }
  
);

api.get('/csrf-cookie')
export {axios,api};