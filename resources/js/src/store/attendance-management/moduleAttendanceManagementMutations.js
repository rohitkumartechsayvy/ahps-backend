/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_SESSIONS(state, attendances) {
    state.attendances = attendances
  },
  SET_ATTENDANCE_EVENTS(state, attendance_events) {
    state.attendance_events = attendance_events
  },
  REMOVE_RECORD(state, attendanceId) {
    const attendanceIndex = state.attendances.findIndex((u) => u.id === attendanceId)
    state.attendances.splice(attendanceIndex, 1)
  }
}
