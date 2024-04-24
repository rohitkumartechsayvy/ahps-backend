/*=========================================================================================
  File Name: moduleContactManagement.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import state from './moduleContactManagementState.js'
import mutations from './moduleContactManagementMutations.js'
import actions from './moduleContactManagementActions.js'
import getters from './moduleContactManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}