/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_TIMETABLES(state, timetables) {
    state.timetables = timetables
  },
  REMOVE_RECORD(state, REMOVE_RECORD) {
    const timetableIndex = state.timetables.findIndex((u) => u.id === REMOVE_RECORD)
    state.timetables.splice(timetableIndex, 1)
  }
}
