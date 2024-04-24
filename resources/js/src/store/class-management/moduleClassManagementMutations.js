/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_CLASSES(state, classes) {
    state.classes = classes
  },
  SET_ASSIGNED_CLASSES(state, assigned_classes) {
    state.assigned_classes = assigned_classes
  },
  SET_CLASS_STUDENT(state, class_students) {
    state.class_students = class_students
  },
  REMOVE_RECORD(state, classId) {
    const classIndex = state.classes.findIndex((u) => u.id === classId)
    state.classes.splice(classIndex, 1)
  }
}
