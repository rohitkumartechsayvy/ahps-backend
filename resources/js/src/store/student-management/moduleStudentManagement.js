/*=========================================================================================
  File Name: moduleStudentManagement.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/Student/pixinvent
==========================================================================================*/


import state from './moduleStudentManagementState.js'
import mutations from './moduleStudentManagementMutations.js'
import actions from './moduleStudentManagementActions.js'
import getters from './moduleStudentManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

