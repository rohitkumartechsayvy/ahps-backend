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
  fetchAllQueries({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/contact-queries`)
        .then((response) => {
          console.log(response.data.response);
          commit('SET_QUERIES', response.data.response)
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchQuery(context, queryId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/fetch-query/${queryId}`)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
}
