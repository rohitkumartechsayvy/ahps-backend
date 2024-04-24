/*=========================================================================================
  File Name: moduleSessionManagement.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import state from './moduleSessionManagementState.js'
import mutations from './moduleSessionManagementMutations.js'
import actions from './moduleSessionManagementActions.js'
import getters from './moduleSessionManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

