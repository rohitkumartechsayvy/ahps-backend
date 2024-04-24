/*=========================================================================================
  File Name: moduleCalendarActions.js
  Description: Calendar Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import axios from '@/axios.js'
import store from './../store.js'
var _token = store.state.AppActiveUser._token;
export default {
  fetchUsers({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/manage-users`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log(response.data.response);
        commit('SET_USERS', response.data.response.users);
        commit('SET_SUPERADMINS', response.data.response.superadmins);
        commit('SET_SUBADMINS', response.data.response.subadmins);
        commit('SET_ACCOUNTANTS', response.data.response.accountants);
        commit('SET_TEACHERS', response.data.response.teachers);
        commit('SET_STUDENTS', response.data.response.students);
        resolve(response);
      }).catch((error) => { reject(error) })
    })
  },
  fetchUser(context, userId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/fetch-user/${userId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  saveUser(context, userId) {
    console.log(userId);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/update-profile/${userId.user_id}`, userId, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        // commit('UPDATE_USER_INFO', response.data.response, { root: true })
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, userId) {
    return new Promise((resolve, reject) => {
      axios.delete(`${process.env.MIX_LIVE_URL}api/v1/delete-user/${userId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('REMOVE_RECORD', userId)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  saveUser2(context, userId) {
    console.log(userId);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/update-profile/${store.state.AppActiveUser.id}`, userId, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        // commit('UPDATE_USER_INFO', response.data.response, { root: true })
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  updatePassword(context, obj) {
    console.log('obj', obj);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/set-password`, obj, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  updateNewPassword(context, obj) {
    console.log('obj', obj);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/update-password`, obj)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
