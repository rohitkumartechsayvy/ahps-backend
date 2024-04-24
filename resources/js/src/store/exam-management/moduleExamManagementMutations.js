/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_EXAMS(state, exams) {
    state.exams = exams
  },
  REMOVE_RECORD(state, examId) {
    const examIndex = state.exams.findIndex((u) => u.id === examId)
    state.exams.splice(examIndex, 1)
  }
}
