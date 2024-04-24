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
  saveSubject({ commit }, data) {
    console.log('data', data);
    return new Promise((resolve, reject) => {
      console.log('MIX_LIVE_URL', process.env.MIX_LIVE_URL);
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/create-subject`, data)
        .then((response) => {
          console.log('classes', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateSubject({ commit }, data) {
    console.log('data', data);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/edit-subject/${data.id}`, data)
        .then((response) => {
          console.log('subjects', response.data)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchSubjects({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-subjects`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_SUBJECTS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchClassSubjects({ commit }, classId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-class-subjects/${classId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_SUBJECTS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchTeacherSubjects({ commit }, classId) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/get-teacher-subjects`, classId, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_SUBJECTS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchStudentReport({ commit }, studentId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/fetch-student-report/${studentId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_SUBJECTS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchSubject(context, subjectId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/subject-detail/${subjectId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, subjectId) {
    return new Promise((resolve, reject) => {
      axios.delete(`${process.env.MIX_LIVE_URL}api/v1/delete-subject/${subjectId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('REMOVE_RECORD', subjectId);
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  }
}
