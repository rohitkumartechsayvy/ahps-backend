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
  createEvent({ commit }, data) {
    console.log('{ commit }', data);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/create-event`, data)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  updateEvent({ commit }, eventId) {
    console.log(eventId);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/update-event/${eventId.id}`, eventId)
        .then((response) => {
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchEvent(context, eventId) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/event-detail/${eventId}`)
        .then((response) => {
          console.log('response', response);
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  approveEvent(context, eventId) {
    return new Promise((resolve, reject) => {
      eventId.approved_by = store.state.AppActiveUser.id;
      console.log('eventIdfght', eventId);
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/approve-event/${eventId.id}`, eventId)
        .then((response) => {
          console.log('response', response);
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  removeEvent(context, eventId) {
    console.log('eventId', eventId);
    return new Promise((resolve, reject) => {
      axios.post(`${process.env.MIX_LIVE_URL}api/v1/remove-event/${eventId}`, eventId)
        .then((response) => {
          console.log('response', response);
          resolve(response)
        })
        .catch((error) => { reject(error) })
    })
  },
  fetchEvents({ commit }) {
    return new Promise((resolve, reject) => {
      axios.get(`${process.env.MIX_LIVE_URL}api/v1/get-events`, { headers: { "Authorization": `Bearer ${_token}` } }).then((response) => {
        commit('SET_EVENTS', response.data.response)
        resolve(response)
      })
        .catch((error) => { reject(error) })
    })
  }
}
