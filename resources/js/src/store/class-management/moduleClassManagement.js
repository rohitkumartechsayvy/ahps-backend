/*=========================================================================================
  File Name: moduleClassManagement.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import state from './moduleClassManagementState.js'
import mutations from './moduleClassManagementMutations.js'
import actions from './moduleClassManagementActions.js'
import getters from './moduleClassManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

