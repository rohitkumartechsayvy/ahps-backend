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
  saveSession({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/create-session`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('sessions', response.data)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  updateSession({ commit }, data) {
    console.log('data', data);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/edit-session/${data.id}`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('subjects', response.data)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchSessions({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-sessions`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_SESSIONS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchSession(context, sessionId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/session-detail/${sessionId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('response', response);
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, sessionId) {
    return new Promise((resolve, reject) => {
      axios.delete(`${process.env.MIX_LIVE_URL}api/v1/delete-session/${sessionId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('REMOVE_RECORD', sessionId)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  }
}
