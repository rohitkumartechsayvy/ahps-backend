/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_CHARGES(state, charges) {
    state.charges = charges
  },
  SET_VOUCHERS(state, vouchers) {
    state.vouchers = vouchers
  },
  REMOVE_RECORD(state, chargeId) {
    const chargeIndex = state.charges.findIndex((u) => u.id === chargeId)
    state.charges.splice(chargeIndex, 1)
  }
}
