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
  fetchTeachers({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-teachers`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('fetchTeachers', response.data);
        commit('SET_TEACHERS', response.data)
        resolve(response)
      }).catch((error) => { reject(error) })
    })
  },
  fetchStudents({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-students`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('fetchStudents', response.data);
        commit('SET_STUDENTS', response.data.response)
        resolve(response)
      }).catch((error) => { reject(error) })
    })
  },
  fetchAssignedStudents({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-assigned-students/${store.state.AppActiveUser.id}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('fetchStudents', response.data);
        commit('SET_STUDENTS', response.data.response)
        resolve(response)
      }).catch((error) => { reject(error) })
    })
  },
  saveStudent({ commit }, data) {
    console.log('data', data);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/create-student`, data)
        .then((response) => {
          console.log('student', response.data)
          commit('SET_USERS', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateStudent({ commit }, data) {
    console.log('data', data);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/update-student/${data.student_id}`, data)
        .then((response) => {
          console.log('student', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchStudent(context, studentId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/student-detail/${studentId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('student', response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, studentId) {
    return new Promise((resolve, reject) => {
      axios.delete(`${process.env.MIX_LIVE_URL}api/v1/delete-user/${studentId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('REMOVE_RECORD', studentId)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
}
