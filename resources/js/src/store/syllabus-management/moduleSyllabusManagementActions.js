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
  saveSyllabus({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/create-syllabus`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('syllabuses', response.data)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  saveAssignment({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/create-assignment`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('syllabuses', response.data)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  updateSyllabus({ commit }, data) {
    console.log('data', data);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/edit-syllabus/${data.id}`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('subjects', response.data)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchClassSyllabus({ commit }, classId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-class-syllabuses/${classId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_SYLLABUSES', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchClassAssignments({ commit }, classId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-class-assignments/${classId.classId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_ASSIGNMENTS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchSyllabus(context, syllabusId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/syllabus-detail/${syllabusId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('response', response);
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, syllabusId) {
    return new Promise((resolve, reject) => {
      axios.delete(`${process.env.MIX_LIVE_URL}api/v1/delete-syllabus/${syllabusId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('REMOVE_RECORD', syllabusId)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  }
}
