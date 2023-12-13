
import axios from "axios";




let options = {
  withCredentials: true,
  headers: {
    Accept: "application/json",
  },
};
const api = axios.create(options);
axios.defaults.baseURL = 'http://localhost:8000/api/';
axios.defaults.withCredentials = false;
export {axios};