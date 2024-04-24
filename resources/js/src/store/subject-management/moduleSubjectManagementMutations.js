/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_SUBJECTS(state, subjects) {
    state.subjects = subjects
  },
  REMOVE_RECORD(state, subjectId) {
    const subjectIndex = state.subjects.findIndex((u) => u.id === subjectId)
    state.subjects.splice(subjectIndex, 1)
  }
}
