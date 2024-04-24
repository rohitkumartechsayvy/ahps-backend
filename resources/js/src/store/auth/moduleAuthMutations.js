/*=========================================================================================
  File Name: moduleAuthMutations.js
  Description: Auth Module Mutations
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import axios from '../../http/axios/index.js'
import store from './../../store/store';
export default {
  SET_BEARER(state, accessToken) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${accessToken}`
  },
  UPDATE_MENU(state, userType) {
    localStorage.removeItem('menu');
    let menu = [];
    let super_admin_menu = [];
    let subadmin_menu = [];
    let accountant_menu = [];
    let student_menu = [];
    let teacher_menu = [];

    if (userType == "super_admin") {
      super_admin_menu = [
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
          name: 'Events',
          icon: 'AwardIcon',
          i18n: 'Events',
          submenu: [
            {
              url: '/create-event',
              name: 'Create',
              slug: 'create-event',
              i18n: 'Create'
            },
            {
              url: '/manage-events',
              name: 'List',
              slug: 'app-event-list',
              i18n: 'List'
            }
          ]
        },
        {
          url: null,
          name: 'Sessions',
          icon: 'UsersIcon',
          i18n: 'Sessions',
          submenu: [
            {
              url: '/create-session',
              name: 'Create',
              slug: 'create-session',
              i18n: 'Create'
            },
            {
              url: '/manage-sessions',
              name: 'List',
              slug: 'app-session-list',
              i18n: 'List'
            }
          ]
        },
        {
          url: null,
          name: 'Schedule Exams',
          icon: 'UsersIcon',
          i18n: 'Schedule Exams',
          submenu: [
            {
              url: '/schedule-exam',
              name: 'Create',
              slug: 'schedule-exam',
              i18n: 'Create'
            },
            {
              url: '/manage-scheduled-exams',
              name: 'List',
              slug: 'app-exam-list',
              i18n: 'List'
            }
          ]
        },
        {
          url: null,
          name: 'Fee Management',
          icon: 'UsersIcon',
          i18n: 'Fee Management',
          submenu: [
            {
              url: '/create-fee',
              name: 'Create',
              slug: 'create-fee',
              i18n: 'Create'
            },
            {
              url: '/manage-tuition-fees',
              name: 'List',
              slug: 'app-tuition-fee-list',
              i18n: 'List'
            }
          ]
        },
        {
          url: null,
          name: 'Fee Vouchers',
          icon: 'UsersIcon',
          i18n: 'Fee Vouchers',
          submenu: [
            {
              url: '/create-fee-voucher',
              name: 'Create',
              slug: 'create-fee-voucher',
              i18n: 'Create'
            },
            {
              url: '/manage-fee-vouchers',
              name: 'List',
              slug: 'manage-fee-vouchers',
              i18n: 'List'
            }
          ]
        },
      ];
    } else if (userType == "subadmin") {
      subadmin_menu = [
        {
          url: '/home',
          name: 'home',
          icon: 'HomeIcon',
          i18n: 'Dashboard'
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
          name: 'Events',
          icon: 'AwardIcon',
          i18n: 'Events',
          submenu: [
            {
              url: '/create-event',
              name: 'Create',
              slug: 'create-event',
              i18n: 'Create'
            },
            {
              url: '/manage-events',
              name: 'List',
              slug: 'app-event-list',
              i18n: 'List'
            }
          ]
        },
        {
          url: null,
          name: 'Sessions',
          icon: 'UsersIcon',
          i18n: 'Sessions',
          submenu: [
            {
              url: '/create-session',
              name: 'Create',
              slug: 'create-session',
              i18n: 'Create'
            },
            {
              url: '/manage-sessions',
              name: 'List',
              slug: 'app-session-list',
              i18n: 'List'
            }
          ]
        },
        {
          url: null,
          name: 'Schedule Exams',
          icon: 'UsersIcon',
          i18n: 'Schedule Exams',
          submenu: [
            {
              url: '/schedule-exam',
              name: 'Create',
              slug: 'schedule-exam',
              i18n: 'Create'
            },
            {
              url: '/manage-scheduled-exams',
              name: 'List',
              slug: 'app-exam-list',
              i18n: 'List'
            }
          ]
        },
        {
          url: null,
          name: 'Fee Management',
          icon: 'UsersIcon',
          i18n: 'Fee Management',
          submenu: [
            {
              url: '/create-fee',
              name: 'Create',
              slug: 'create-fee',
              i18n: 'Create'
            },
            {
              url: '/manage-tuition-fees',
              name: 'List',
              slug: 'app-tuition-fee-list',
              i18n: 'List'
            }
          ]
        },
        {
          url: null,
          name: 'Fee Vouchers',
          icon: 'UsersIcon',
          i18n: 'Fee Vouchers',
          submenu: [
            {
              url: '/create-fee-voucher',
              name: 'Create',
              slug: 'create-fee-voucher',
              i18n: 'Create'
            },
            {
              url: '/manage-fee-vouchers',
              name: 'List',
              slug: 'manage-fee-vouchers',
              i18n: 'List'
            }
          ]
        },
      ];
    } else if (userType == "accountant") {
      accountant_menu = [
        {
          url: '/home',
          name: 'home',
          icon: 'HomeIcon',
          i18n: 'Dashboard'
        },
        {
          url: null,
          name: 'Students',
          icon: 'SmileIcon',
          i18n: 'Students',
          submenu: [
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
              url: '/manage-classes',
              name: 'List',
              slug: 'app-class-list',
              i18n: 'List'
            }
          ]
        },
        {
          url: null,
          name: 'Fee Management',
          icon: 'UsersIcon',
          i18n: 'Fee Management',
          submenu: [
            {
              url: '/create-fee',
              name: 'Create',
              slug: 'create-fee',
              i18n: 'Create'
            },
            {
              url: '/manage-tuition-fees',
              name: 'List',
              slug: 'app-tuition-fee-list',
              i18n: 'List'
            }
          ]
        },
        {
          url: null,
          name: 'Fee Vouchers',
          icon: 'UsersIcon',
          i18n: 'Fee Vouchers',
          submenu: [
            {
              url: '/create-fee-voucher',
              name: 'Create',
              slug: 'create-fee-voucher',
              i18n: 'Create'
            },
            {
              url: '/manage-fee-vouchers',
              name: 'List',
              slug: 'manage-fee-vouchers',
              i18n: 'List'
            }
          ]
        },
        {
          url: null,
          name: 'Events',
          icon: 'AwardIcon',
          i18n: 'Events',
          submenu: [
            {
              url: '/create-event',
              name: 'Create',
              slug: 'create-event',
              i18n: 'Create'
            },
            {
              url: '/manage-events',
              name: 'List',
              slug: 'app-event-list',
              i18n: 'List'
            }
          ]
        },
        {
          url: null,
          name: 'Sessions',
          icon: 'UsersIcon',
          i18n: 'Sessions',
          submenu: [
            {
              url: '/create-session',
              name: 'Create',
              slug: 'create-session',
              i18n: 'Create'
            },
            {
              url: '/manage-sessions',
              name: 'List',
              slug: 'app-session-list',
              i18n: 'List'
            }
          ]
        },
      ];
    } else if (userType == "teacher") {
      teacher_menu = [
        {
          url: '/home',
          name: 'home',
          icon: 'HomeIcon',
          i18n: 'Dashboard'
        },
        {
          url: `/classes/${store.state.AppActiveUser.id}`,
          name: 'Classes Assigned',
          icon: 'AwardIcon',
          i18n: 'Classes Assigned'
        },
        {
          url: `/subject-classes/${store.state.AppActiveUser.id}`,
          name: 'Subject Classes',
          icon: 'AwardIcon',
          i18n: 'Subject Classes'
        },
        {
          url: `/teacher-timetable/${store.state.AppActiveUser.id}`,
          name: 'Timetable',
          icon: 'AwardIcon',
          i18n: 'Timetable'
        },
        {
          url: `/events`,
          name: 'Events',
          icon: 'AwardIcon',
          i18n: 'Events'
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
          name: 'Schedule Exams',
          icon: 'UsersIcon',
          i18n: 'Schedule Exams',
          submenu: [
            {
              url: '/manage-scheduled-exams',
              name: 'List',
              slug: 'app-exam-list',
              i18n: 'List'
            }
          ]
        },
      ];
    } else if (userType == "student") {
      student_menu = [
        {
          url: '/home',
          name: 'home',
          icon: 'HomeIcon',
          i18n: 'Dashboard'
        },
        {
          url: `/fee-details/${store.state.AppActiveUser.id}`,
          name: 'Fee Details',
          icon: 'AwardIcon',
          i18n: 'Fee Details'
        },
        {
          url: `/student-timetable/${store.state.AppActiveUser.id}`,
          name: 'Timetable',
          icon: 'AwardIcon',
          i18n: 'Timetable'
        },
        {
          url: `/student-attendance/${store.state.AppActiveUser.id}`,
          name: 'Attendance',
          icon: 'AwardIcon',
          i18n: 'Attendance'
        },
        {
          url: `/assignments/${store.state.AppActiveUser.id}`,
          name: 'Assignments',
          icon: 'AwardIcon',
          i18n: 'Homework'
        },
        {
          url: null,
          name: 'Schedule Exams',
          icon: 'UsersIcon',
          i18n: 'Schedule Exams',
          submenu: [
            {
              url: '/manage-scheduled-exams',
              name: 'List',
              slug: 'app-exam-list',
              i18n: 'List'
            }
          ]
        },
        {
          url: `/events`,
          name: 'Events',
          icon: 'AwardIcon',
          i18n: 'Events'
        },
      ];
    }
    // Store data in localStorage
    localStorage.setItem('super_admin_menu', JSON.stringify(super_admin_menu));
    localStorage.setItem('subadmin_menu', JSON.stringify(subadmin_menu));
    localStorage.setItem('accountant_menu', JSON.stringify(accountant_menu));
    localStorage.setItem('teacher_menu', JSON.stringify(teacher_menu));
    localStorage.setItem('student_menu', JSON.stringify(student_menu));
    state.menu = menu;
  }
}
