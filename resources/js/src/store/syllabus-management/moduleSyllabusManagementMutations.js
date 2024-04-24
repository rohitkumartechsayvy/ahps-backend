/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_SYLLABUSES(state, syllabuses) {
    state.syllabuses = syllabuses
  },
  SET_ASSIGNMENTS(state, assignments) {
    state.assignments = assignments
  },
  REMOVE_RECORD(state, syllabusId) {
    const syllabusIndex = state.syllabuses.findIndex((u) => u.id === syllabusId)
    state.syllabuses.splice(syllabusIndex, 1)
  }
}
