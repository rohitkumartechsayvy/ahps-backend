/*=========================================================================================
  File Name: moduleEventManagement.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/Event/pixinvent
==========================================================================================*/


import state from './moduleEventManagementState.js'
import mutations from './moduleEventManagementMutations.js'
import actions from './moduleEventManagementActions.js'
import getters from './moduleEventManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

