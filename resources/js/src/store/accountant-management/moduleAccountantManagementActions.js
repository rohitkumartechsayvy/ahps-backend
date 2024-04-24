/*=========================================================================================
  File Name: moduleCalendarActions.js
  Description: Calendar Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import axios from '@/axios.js'
import store from './../../store/store';
var _token = store.state.AppActiveUser._token;

export default {
  fetchAccountants({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-accountants`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_ACCOUNTANTS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  saveAccountant({ commit }, data) {
    console.log('data', data);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/create-accountant`, data)
        .then((response) => {
          console.log('accountant', response.data)
          commit('SET_USERS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateAccountant(context, userId) {
    console.log(userId);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/update-profile/${userId.user_id}`, userId, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        // commit('UPDATE_USER_INFO', response.data.response, { root: true })
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
  },
  fetchAccountant(context, accountantId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/accountant-detail/${accountantId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, accountantId) {
    return new Promise((resolve, reject) => {
      axios.delete(`${process.env.MIX_LIVE_URL}api/v1/delete-user/${accountantId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('REMOVE_RECORD', accountantId)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
}
