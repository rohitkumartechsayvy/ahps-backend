/*=========================================================================================
  File Name: moduleTuitionFeeManagement.js
  Description: Calendar Module
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import state from './moduleTuitionFeeManagementState.js'
import mutations from './moduleTuitionFeeManagementMutations.js'
import actions from './moduleTuitionFeeManagementActions.js'
import getters from './moduleTuitionFeeManagementGetters.js'

export default {
  isRegistered: false,
  namespaced: true,
  state,
  mutations,
  actions,
  getters
}

