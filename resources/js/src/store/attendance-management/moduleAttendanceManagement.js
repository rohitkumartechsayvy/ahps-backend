/*=========================================================================================
  File Name: moduleAttendanceManagement.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import state from './moduleAttendanceManagementState.js'
import mutations from './moduleAttendanceManagementMutations.js'
import actions from './moduleAttendanceManagementActions.js'
import getters from './moduleAttendanceManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

