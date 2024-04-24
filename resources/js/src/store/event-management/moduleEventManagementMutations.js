/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_EVENTS(state, events) {
    state.events = events
  },
  REMOVE_RECORD(state, itemId) {
    const userIndex = state.events.findIndex((u) => u.id === itemId)
    state.events.splice(userIndex, 1)
  }
}
