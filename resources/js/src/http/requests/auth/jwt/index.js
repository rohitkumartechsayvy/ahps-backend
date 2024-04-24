import axios from '../../../axios/index.js'
import store from '../../../../store/store.js'

// Token Refresh
let isAlreadyFetchingAccessToken = false
let subscribers = []

function onAccessTokenFetched(access_token) {
  subscribers = subscribers.filter(callback => callback(access_token))
}

function addSubscriber(callback) {
  subscribers.push(callback)
}

export default {
  init() {

    axios.interceptors.response.use(function (response) {
      console.log('inteceptor response', response);
      if (response.data.message === 'Token Expired') {
        if (localStorage.getItem("userInfo")) {
          console.log("first", localStorage.getItem("accessToken"));
          localStorage.removeItem("userInfo");
          localStorage.removeItem("menu");
          localStorage.removeItem("super_admin_menu");
          localStorage.removeItem("subadmin_menu");
          localStorage.removeItem("accountant_menu");
          localStorage.removeItem("teacher_menu");
          localStorage.removeItem("student_menu");
          console.log("then", localStorage.getItem("accessToken"));
          location.reload();
          this.$vs.loading.close();
          this.$vs.notify({
            title: "Error",
            text: "Your Login Has Expired!",
            iconPack: "feather",
            icon: "icon-alert-circle",
            color: "danger",
          });
          this.$router.push({ path: "login" });
        } else {
          localStorage.removeItem("userInfo");
          localStorage.removeItem("menu");
          localStorage.removeItem("super_admin_menu");
          localStorage.removeItem("subadmin_menu");
          localStorage.removeItem("accountant_menu");
          localStorage.removeItem("teacher_menu");
          localStorage.removeItem("student_menu");
          location.reload();
          this.$vs.loading.close();
          this.$vs.notify({
            title: "Error",
            text: "Your Login Has Expired!",
            iconPack: "feather",
            icon: "icon-alert-circle",
            color: "danger",
          });
          this.$router.push({ path: "login" });
        }
      }
      return response
    }, function (error) {
      console.log('inteceptor error', error);
      // const { config, response: { status } } = error
      const { config, response } = error
      const originalRequest = config

      // if (status === 401) {
      if (response && response.status === 401) {
        if (!isAlreadyFetchingAccessToken) {
          isAlreadyFetchingAccessToken = true
          store.dispatch('auth/fetchAccessToken')
            .then((access_token) => {
              isAlreadyFetchingAccessToken = false
              onAccessTokenFetched(access_token)
            })
        }

        const retryOriginalRequest = new Promise((resolve) => {
          addSubscriber(access_token => {
            originalRequest.headers.Authorization = `Bearer ${access_token}`
            resolve(axios(originalRequest))
          })
        })
        return retryOriginalRequest
      }
      return Promise.reject(error)
    })
  },
  login(email, pwd) {
    console.log(email);
    console.log(pwd);
    return axios.post('/api/auth/login', {
      email,
      password: pwd
    })
  },
  registerUser(name, email, pwd) {
    return axios.post('/api/auth/register', {
      displayName: name,
      email,
      password: pwd
    })
  },
  refreshToken() {
    return axios.post('/api/auth/refresh-token', { accessToken: localStorage.getItem('accessToKen') })
  }
}
