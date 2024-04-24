/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_ASSIGNMENTS(state, assignments) {
    state.assignments = assignments
  },
  REMOVE_RECORD(state, assignmentId) {
    const assignmentIndex = state.assignments.findIndex((u) => u.id === assignmentId)
    state.assignments.splice(assignmentIndex, 1)
  }
}
