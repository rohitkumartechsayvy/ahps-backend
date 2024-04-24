/*=========================================================================================
  File Name: moduleSyllabusManagement.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import state from './moduleSyllabusManagementState.js'
import mutations from './moduleSyllabusManagementMutations.js'
import actions from './moduleSyllabusManagementActions.js'
import getters from './moduleSyllabusManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

