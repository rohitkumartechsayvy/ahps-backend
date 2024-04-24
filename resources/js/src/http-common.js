// axios
import axios from 'axios'

const baseURL = ''

export default axios.create({
  baseURL: "http://localhost:8080",
  headers: {
    "Content-type": "application/json"
  }
});

