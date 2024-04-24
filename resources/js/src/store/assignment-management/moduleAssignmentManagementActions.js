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
  saveAssignment({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/create-assignment`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('assignments', response.data)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  checkAssignment({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/check-assignment`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('assignments', response.data)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  submitAssignment({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/upload-assignment`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('assignments', response.data)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  submitAadhar({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/upload-aadhar`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('assignments', response.data)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  updateAssignment({ commit }, data) {
    console.log('data', data);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/edit-assignment/${data.id}`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('subjects', response.data)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchAssignments({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-assignments`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_ASSIGNMENTS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchStudentAssignments({ commit }, studentId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-student-assignments/${studentId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_ASSIGNMENTS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchAssignment(context, assignmentId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/assignment-detail/${assignmentId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('response', response);
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, assignmentId) {
    return new Promise((resolve, reject) => {
      axios.delete(`${process.env.MIX_LIVE_URL}api/v1/delete-assignment/${assignmentId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('REMOVE_RECORD', assignmentId)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  }
}
