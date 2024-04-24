/*=========================================================================================
  File Name: moduleTeacherManagement.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/Teacher/pixinvent
==========================================================================================*/


import state from './moduleTeacherManagementState.js'
import mutations from './moduleTeacherManagementMutations.js'
import actions from './moduleTeacherManagementActions.js'
import getters from './moduleTeacherManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

