/*=========================================================================================
  File Name: moduleAssignmentManagement.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import state from './moduleAssignmentManagementState.js'
import mutations from './moduleAssignmentManagementMutations.js'
import actions from './moduleAssignmentManagementActions.js'
import getters from './moduleAssignmentManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

