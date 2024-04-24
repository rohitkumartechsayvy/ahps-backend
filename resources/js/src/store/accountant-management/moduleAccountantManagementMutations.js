/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_ACCOUNTANTS(state, accountants) {
    state.accountants = accountants
  },
  REMOVE_RECORD(state, accountantId) {
    const accountantIndex = state.accountants.findIndex((u) => u.id === accountantId)
    state.accountants.splice(accountantIndex, 1)
  }
}
