/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_USERS(state, users) {
    state.users = users
  },
  SET_SUPERADMINS(state, superadmins) {
    state.superadmins = superadmins
  },
  SET_SUBADMINS(state, subadmins) {
    state.subadmins = subadmins
  },
  SET_ACCOUNTANTS(state, accountants) {
    state.accountants = accountants
  },
  SET_TEACHERS(state, teachers) {
    state.teachers = teachers
  },
  SET_STUDENTS(state, students) {
    state.students = students
  },
  REMOVE_RECORD(state, itemId) {
    const userIndex = state.users.findIndex((u) => u.id === itemId)
    state.users.splice(userIndex, 1)
  },
  SET_BEARER(state, accessToken) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${accessToken}`
  }
}
