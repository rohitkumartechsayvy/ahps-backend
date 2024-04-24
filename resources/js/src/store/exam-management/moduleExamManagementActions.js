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
  saveExam({ commit }, data) {
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/create-exam`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  updateExam({ commit }, data) {
    console.log('data', data);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/edit-exam/${data.id}`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('subjects', response.data)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchExams({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-exams`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_EXAMS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchActiveExams({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-active-exams`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_EXAMS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchExam(context, examId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/exam-detail/${examId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('response', response);
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, examId) {
    return new Promise((resolve, reject) => {
      axios.delete(`${process.env.MIX_LIVE_URL}api/v1/delete-exam/${examId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('REMOVE_RECORD', examId)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  saveExamLogs({ commit }, data) {
    return new Promise((resolve, reject) => {
      console.log('data', data);
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/save-exam-logs`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {

        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  generateReportCard({ commit }, data) {
    return new Promise((resolve, reject) => {
      console.log('data', data);
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/generate-report-card`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {

        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchStudentReportCard({ commit }, data) {
    return new Promise((resolve, reject) => {
      console.log('data', data);
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/report-card/${data.exam_id}/${data.student_id}`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
}
