/*=========================================================================================
  File Name: moduleTimeTableManagement.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/TimeTable/pixinvent
==========================================================================================*/


import state from './moduleTimeTableManagementState.js'
import mutations from './moduleTimeTableManagementMutations.js'
import actions from './moduleTimeTableManagementActions.js'
import getters from './moduleTimeTableManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

