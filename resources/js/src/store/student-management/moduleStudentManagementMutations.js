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
  SET_TEACHERS(state, teachers) {
    state.teachers = teachers
  },
  SET_STUDENTS(state, students) {
    state.students = students
  },
  REMOVE_RECORD(state, studentId) {
    const studentIndex = state.students.findIndex((u) => u.id === studentId)
    state.students.splice(studentIndex, 1)
  }
}
