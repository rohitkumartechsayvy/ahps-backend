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
  saveTuitionFee({ commit }, data) {
    return new Promise((resolve, reject) => {
      console.log('data', data);
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/create-charges`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('sessions', response.data)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  createVoucher({ commit }, data) {
    return new Promise((resolve, reject) => {
      console.log('data', data);
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/create-fee-voucher`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('sessions', response.data)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  updateCharge({ commit }, data) {
    console.log('data', data);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/edit-charge/${data.id}`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('subjects', response.data)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  payNow({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/pay-now`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  savePayment({ commit }, data) {
    return new Promise(async (resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/save-payment`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  cashPayment({ commit }, data) {
    return new Promise(async (resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/cash-payment`, data, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchCharges({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-charges`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_CHARGES', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  getOnlyCharges({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-only-charges`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_CHARGES', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchFeeVouchers({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/fetch-fee-vouchers`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_VOUCHERS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchStudentVouchers({ commit }, studentId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/fetch-student-fee-vouchers/${studentId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_VOUCHERS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  GetVoucherDetails({ commit }, Id) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-voucher-detail/${Id}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_VOUCHERS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  fetchCharge(context, chargeId) {
    return new Promise((resolve, reject) => {
      console.log('chargeId', chargeId);
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/charge-detail/${chargeId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        console.log('response', response);
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, chargeId) {
    return new Promise((resolve, reject) => {
      axios.delete(`${process.env.MIX_LIVE_URL}api/v1/delete-charge/${chargeId}`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('REMOVE_RECORD', chargeId)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  }
}
