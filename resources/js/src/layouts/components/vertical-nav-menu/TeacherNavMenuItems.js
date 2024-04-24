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

export default [
  {
    url: '/home',
    name: 'home',
    icon: 'HomeIcon',
    i18n: 'Dashboard'
  },
  {
    url: null,
    name: 'Users',
    icon: 'UserIcon',
    i18n: 'Users',
    submenu: [
      {
        url: '/manage-users',
        name: 'manage-users',
        slug: 'manage-users',
        i18n: 'Manage Users'
      }
    ]
  },
  {
    url: null,
    name: 'Sub Admins',
    icon: 'BriefcaseIcon',
    i18n: 'Sub Admins',
    submenu: [
      {
        url: '/create-subadmin',
        name: 'Create',
        slug: 'create-subadmin',
        i18n: 'Create'
      },
      {
        url: '/manage-subadmins',
        name: 'List',
        slug: 'app-subadmin-list',
        i18n: 'List'
      }
    ]
  },
  {
    url: null,
    name: 'Accountants',
    icon: 'CalendarIcon',
    i18n: 'Accountants',
    submenu: [
      {
        url: '/create-accountant',
        name: 'Create',
        slug: 'create-accountant',
        i18n: 'Create'
      },
      {
        url: '/manage-accountants',
        name: 'List',
        slug: 'app-accountant-list',
        i18n: 'List'
      },
    ]
  },
  {
    url: null,
    name: 'Teachers',
    icon: 'UsersIcon',
    i18n: 'Teachers',
    submenu: [
      {
        url: '/create-teacher',
        name: 'Create',
        slug: 'create-teacher',
        i18n: 'Create'
      },
      {
        url: '/manage-teachers',
        name: 'List',
        slug: 'app-teacher-list',
        i18n: 'List'
      }
    ]
  },
  {
    url: null,
    name: 'Students',
    icon: 'SmileIcon',
    i18n: 'Students',
    submenu: [
      {
        url: '/create-student',
        name: 'Create',
        slug: 'create-student',
        i18n: 'Create'
      },
      {
        url: '/manage-students',
        name: 'List',
        slug: 'app-student-list',
        i18n: 'List'
      },
    ]
  },
  {
    url: null,
    name: 'Classes',
    icon: 'AwardIcon',
    i18n: 'Classes',
    submenu: [
      {
        url: '/create-class',
        name: 'Create',
        slug: 'create-class',
        i18n: 'Create'
      },
      {
        url: '/manage-classes',
        name: 'List',
        slug: 'app-class-list',
        i18n: 'List'
      }
    ]
  },
  {
    url: null,
    name: 'Subjects',
    icon: 'ListIcon',
    i18n: 'Subjects',
    submenu: [
      {
        url: '/create-subject',
        name: 'Create',
        slug: 'create-subject',
        i18n: 'Create'
      },
      {
        url: '/manage-subjects',
        name: 'List',
        slug: 'app-subject-list',
        i18n: 'List'
      }
    ]
  },
  {
    url: null,
    name: 'Fee Management',
    icon: 'AwardIcon',
    i18n: 'Fee Management',
    submenu: [
      {
        url: '/create-class',
        name: 'Create',
        slug: 'create-class',
        i18n: 'Create'
      },
      {
        url: '/manage-classes',
        name: 'List',
        slug: 'app-class-list',
        i18n: 'List'
      }
    ]
  },
  {
    url: null,
    name: 'Time Table',
    icon: 'AwardIcon',
    i18n: 'Time Table',
    submenu: [
      {
        url: '/create-timetable',
        name: 'Create',
        slug: 'create-timetable',
        i18n: 'Create'
      },
      {
        url: '/manage-timetables',
        name: 'List',
        slug: 'app-timetable-list',
        i18n: 'List'
      }
    ]
  },
]

