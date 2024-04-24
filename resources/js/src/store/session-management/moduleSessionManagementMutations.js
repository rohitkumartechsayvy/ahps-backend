/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_SESSIONS(state, sessions) {
    state.sessions = sessions
  },
  REMOVE_RECORD(state, sessionId) {
    const sessionIndex = state.sessions.findIndex((u) => u.id === sessionId)
    state.sessions.splice(sessionIndex, 1)
  }
}
