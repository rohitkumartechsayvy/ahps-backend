/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  Strucutre:
          url     => router path
          name    => name to display in sidebar
          slug    => router path name
          icon    => Feather Icon component/icon name
          tag     => text to display on badge
          tagColor  => class to apply on badge element
          i18n    => Internationalization
          submenu   => submenu of current item (current item will become dropdown )
                NOTE: Submenu don't have any icon(you can add icon if u want to display)
          isDisabled  => disable sidebar item/group
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
import store from "./../../../store/store";
let menu = [];
const role = store.state.AppActiveUser.user_type;
if (role == 'super_admin') {
  menu = JSON.parse(localStorage.getItem('super_admin_menu'));
} else if (role == 'subadmin') {
  menu = JSON.parse(localStorage.getItem('subadmin_menu'));
} else if (role == 'accountant') {
  menu = JSON.parse(localStorage.getItem('accountant_menu'));
} else if (role == 'teacher') {
  menu = JSON.parse(localStorage.getItem('teacher_menu'));
} else if (role == 'student') {
  menu = JSON.parse(localStorage.getItem('student_menu'));
}
// console.log('localStorage.getItem()', localStorage.removeItem('menu'));
console.log('menu', menu);
export default menu;


