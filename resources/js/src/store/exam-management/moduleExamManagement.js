/*=========================================================================================
  File Name: moduleExamManagement.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import state from './moduleExamManagementState.js'
import mutations from './moduleExamManagementMutations.js'
import actions from './moduleExamManagementActions.js'
import getters from './moduleExamManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

