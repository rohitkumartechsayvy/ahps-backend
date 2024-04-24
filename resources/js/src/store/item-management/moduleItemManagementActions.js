/*=========================================================================================
  File Name: moduleCalendarActions.js
  Description: Calendar Module Actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import axios from '@/axios.js'

export default {
  fetchAllItems({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/all-items')
        .then((response) => {
          commit('SET_ITEMS', response.data.response)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  soldItems({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/sold-items')
        .then((response) => {
          commit('SET_ITEMS', response.data.response)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  ebaySoldItems({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get('/api/ebay-sold-items')
        .then((response) => {
          commit('SET_ITEMS', response.data.response)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchItems({ commit }, userId) {
    return new Promise((resolve, reject) => {
      axios.get(`/api/view-items/${userId}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchItem(context, userId) {
    return new Promise((resolve, reject) => {
      axios.get(`/api/item-user/${userId}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  getItem({ commit }, itemId) {
    return new Promise((resolve, reject) => {
      axios.get(`/api/get-item/${itemId}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  saveItem(context, userId) {
    return new Promise((resolve, reject) => {
      axios.post(`/api/update-item/${userId.id}`, userId)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  uploadImage(context, userId) {
    return new Promise((resolve, reject) => {
      axios.post(`/api/update-image`, userId)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  createItem(context, userId) {
    return new Promise((resolve, reject) => {
      axios.post(`/api/create-item`, userId)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeRecord({ commit }, ItemId) {
    return new Promise((resolve, reject) => {
      axios.delete(`/api/delete-item/${ItemId}`)
        .then((response) => {
          commit('REMOVE_RECORD', ItemId)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
