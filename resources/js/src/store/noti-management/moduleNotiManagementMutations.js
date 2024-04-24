/*=========================================================================================
  File Name: moduleCalendarMutations.js
  Description: Calendar Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default {
  SET_ITEMS(state, items) {
    state.items = items
  },
  SET_SOLD_ITEMS(state, sold_items) {
    state.sold_items = sold_items
  },
  SET_EBAY_SOLD_ITEMS(state, ebay_sold_items) {
    state.ebay_sold_items = ebay_sold_items
  },
  REMOVE_RECORD(state, itemId) {
    const userIndex = state.items.findIndex((u) => u.id === itemId)
    state.items.splice(userIndex, 1)
  },
}
