/*=========================================================================================
  File Name: moduleAuthActions.js
  Description: Auth Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import jwt from '../../http/requests/auth/jwt/index.js'


import router from '@/router'

export default {


  // JWT
  loginJWT({ commit }, payload) {

    return new Promise((resolve, reject) => {
      jwt.login(payload.userDetails.email, payload.userDetails.password)
        .then(response => {
          // If there's user data in response
          if (response.data.response) {
            // Navigate User to homepage
            router.push(router.currentRoute.query.to || '/')
            // Set accessToken
            localStorage.setItem('accessToken', response.data.response._token)
            // Update user details
            console.log('response22', response.data.response);
            commit('UPDATE_USER_INFO', response.data.response, { root: true })
            commit('UPDATE_MENU', response.data.response.user_type)
            // Set bearer token in axios
            commit('SET_BEARER', response.data.response._token)
            resolve(response)
          } else {
            reject({ message: 'Wrong Email or Password' })
          }

        })
        .catch(error => { reject(error) })
    })
  },
  registerUserJWT({ commit }, payload) {

    const { displayName, email, password, confirmPassword } = payload.userDetails

    return new Promise((resolve, reject) => {

      // Check confirm password
      if (password !== confirmPassword) {
        reject({ message: 'Password doesn\'t match. Please try again.' })
      }

      jwt.registerUser(displayName, email, password)
        .then(response => {
          // Redirect User
          router.push(router.currentRoute.query.to || '/')

          // Update data in localStorage
          localStorage.setItem('accessToken', response.data.accessToken)
          commit('UPDATE_USER_INFO', response.data.userData, { root: true })
          commit('UPDATE_MENU', response.data.user_type)
          resolve(response)
        })
        .catch(error => { reject(error) })
    })
  },
  fetchAccessToken() {
    return new Promise((resolve) => {
      jwt.refreshToken().then(response => { resolve(response) })
    })
  }
}
