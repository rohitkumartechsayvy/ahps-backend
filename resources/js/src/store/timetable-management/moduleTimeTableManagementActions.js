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
  saveTimeTable(context, data) {
    console.log(data);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/create-timetable`, data)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateTimetable({ commit }, timetableId) {
    console.log(timetableId);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/update-timetable/${timetableId.time_table_id}`, timetableId, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchTimeTable(context, timetableId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/class-timetable/${timetableId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('response', response);
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchTimetables({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-timetables`)
        .then((response) => {
          commit('SET_TIMETABLES', response.data.response)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchHours({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-hours`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchDays({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-days`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchTeacherTimeTable(context, teacherId) {
    return new Promise((resolve, reject) => {
      let id = null;
      if (teacherId) {
        id = teacherId
      } else {
        id = store.state.AppActiveUser.id;
      }
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/teacher-timetable/${id}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('response', response);
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchStudentTimeTable(context, studentId) {
    return new Promise((resolve, reject) => {
      let id = null;
      if (studentId) {
        id = studentId
      } else {
        id = store.state.AppActiveUser.id;
      }
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/student-timetable/${id}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('response', response);
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  getRecord(context, data) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-record/${data.hour_id}/${data.day_id}/${data.teacher_id}`)
        .then((response) => {
          console.log('response', response);
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, timetableId) {
    return new Promise((resolve, reject) => {
      axios.delete(`/api/v1/delete-timetable/${timetableId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('REMOVE_RECORD', timetableId)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  }
}
