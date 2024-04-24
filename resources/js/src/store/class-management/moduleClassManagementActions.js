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
  saveClass({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/create-class`, data)
        .then((response) => {
          console.log('classes', response.data)
          commit('SET_CLASSES', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateClass({ commit }, data) {
    console.log('data', data);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/edit-class/${data.id}`, data)
        .then((response) => {
          console.log('classes', response.data)
          commit('SET_CLASSES', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateFee({ commit }, data) {
    console.log('data', data);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/update-fee`, data)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchClasses({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-classes`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_CLASSES', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchAssignedClasses({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-assigned-classes/${store.state.AppActiveUser.id}`)
        .then((response) => {
          console.log('response.data.response', response.data.response);
          commit('SET_ASSIGNED_CLASSES', response.data.response)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchSubjectClasses({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-subject-classes/${store.state.AppActiveUser.id}`)
        .then((response) => {
          console.log('response.data.response', response.data.response);
          commit('SET_ASSIGNED_CLASSES', response.data.response)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchClass(context, classId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/class-detail/${classId}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchClassStudents({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-students-by-class/${data}`)
        .then((response) => {
          console.log('response.data.response', response.data.response);
          commit('SET_CLASS_STUDENT', response.data.response)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  markAllAbsent({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/mark-all-absent`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  markAllPresent({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/mark-all-present`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  markAttendance({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/mark-attendance`, data)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  checkAttendance({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/check-attendance`, data)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchAttendance({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/fetch-attendance`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('response.data.response', response.data.response);
        commit('SET_CLASS_STUDENT', response.data.response);
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  getMonths({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-months`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, userId) {
    return new Promise((resolve, reject) => {
      axios.delete(`${process.env.MIX_LIVE_URL}api/v1/delete-class/${userId}`)
        .then((response) => {
          commit('REMOVE_RECORD', userId)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  getMonthlyFee(context, classId) {
    return new Promise((resolve, reject) => {
      axios.delete(`${process.env.MIX_LIVE_URL}api/v1/fetch-monthly-fee/${classId}`)
        .then((response) => {
          console.log('monthly fee response', response);
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
