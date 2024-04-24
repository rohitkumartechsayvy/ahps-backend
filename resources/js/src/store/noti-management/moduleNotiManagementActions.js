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
  fetchItems({ commit }, userId) {
    return new Promise((resolve, reject) => {
      axios.get(`/api/view-items/${userId}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  saveNoti(context, userId) {
    return new Promise((resolve, reject) => {
      let obj = {
        message: userId.message
      }
      axios.post(`/api/send-notification`, obj)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  }
}
