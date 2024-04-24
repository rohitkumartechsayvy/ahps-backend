/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  Object Strucutre:
                    path => router path
                    name => router name
                    component(lazy loading) => component to load
                    meta : {
                      rule => which user can have access (ACL)
                      breadcrumb => Add breadcrumb to specific page
                      pageTitle => Display title besides breadcrumb
                    }
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import Vue from 'vue'
import Router from 'vue-router'
import store from './../src/store/store'
Vue.use(Router)
const router = new Router({
  mode: 'history',
  base: '/',
  scrollBehavior() {
    return { x: 0, y: 0 }
  },
  routes: [
    {
      // =============================================================================
      // MAIN LAYOUT ROUTES
      // =============================================================================
      path: '',
      component: () => import('./layouts/main/Dashboard.vue'),
      children: [
        // =============================================================================
        // Theme Routes
        // =============================================================================
        {
          path: '/',
          redirect: '/home'
        },
        {
          path: '/home',
          name: 'home',
          component: () => {
            if (store.state.AppActiveUser.user_type == 'student') {
              return import(/* webpackChunkName: "app-home" */ '@/views/apps/students/StudentTimetableView.vue');
            } else if (store.state.AppActiveUser.user_type == 'teacher') {
              return import(/* webpackChunkName: "app-home" */ '@/views/apps/teachers/TeacherTimetableView.vue');
            } else if (store.state.AppActiveUser.user_type == 'subadmin') {
              return import(/* webpackChunkName: "app-home" */ '@/views/apps/timetables/manage-timetables/TimeTableDetailAdmin.vue');
            } else {
              return import(/* webpackChunkName: "app-home" */ '@/views/apps/timetables/manage-timetables/TimeTableDetailAdmin.vue');
            }
          },
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/manage-users',
          name: 'manage-users',
          component: () => import('@/views/apps/user/manage-users/ManageUsers.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Users', url: '/manage-users' },
              { title: 'Manage Users', active: true }
            ],
            pageTitle: 'Manage Users',
            rule: 'editor'
          },
        },
        {
          path: '/manage-subadmins',
          name: 'manage-subadmins',
          component: () => import('@/views/apps/subadmins/manage-subadmins/ManageSubAdmins.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Sub Admins', url: '/manage-subadmins' },
              { title: 'Manage Sub Admins', active: true }
            ],
            pageTitle: 'Manage Sub Admins',
            rule: 'editor'
          }
        },
        {
          path: '/manage-accountants',
          name: 'manage-accountants',
          component: () => import('@/views/apps/accountants/manage-accountants/ManageAccountants.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Accountants', url: '/manage-accountants' },
              { title: 'Manage Accountants', active: true }
            ],
            pageTitle: 'Manage Accountants',
            rule: 'editor'
          }
        },
        {
          path: '/manage-teachers',
          name: 'manage-teachers',
          component: () => import('@/views/apps/teachers/manage-teachers/ManageTeacher.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Teachers', url: '/manage-teachers' },
              { title: 'Manage Teachers', active: true }
            ],
            pageTitle: 'Manage Teachers',
            rule: 'editor'
          }
        },
        {
          path: '/classes/:teacherId',
          name: 'classes',
          component: () => import('@/views/apps/classes/manage-classes/ClassAssigned.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Classes Assigned', active: true }
            ],
            pageTitle: 'Classes Assigned',
            rule: 'editor'
          }
        },
        {
          path: '/subject-classes/:teacherId',
          name: 'subject-classes',
          component: () => import('@/views/apps/classes/manage-classes/SubjectClasses.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Subject Classes', active: true }
            ],
            pageTitle: 'Subject Classes',
            rule: 'editor'
          }
        },
        {
          path: '/teacher-timetable/:teacherId',
          name: 'teacher-timetable',
          component: () => import('@/views/apps/teachers/TeacherTimetableView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'TimeTable', url: '/manage-teachers' },
              { title: 'View TimeTable', active: true }
            ],
            pageTitle: 'View TimeTable',
            rule: 'editor'
          }
        },
        {
          path: '/student-timetable/:studentId',
          name: 'student-timetable',
          component: () => import('@/views/apps/students/StudentTimetableView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'View TimeTable', active: true }
            ],
            pageTitle: 'View TimeTable',
            rule: 'editor'
          }
        },
        {
          path: '/student-attendance/:studentId',
          name: 'student-attendance',
          component: () => import('@/views/apps/students/StudentAttendanceView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'View Attendance', active: true }
            ],
            pageTitle: 'View Attendance',
            rule: 'editor'
          }
        },
        {
          path: '/class-attendance/:classId',
          name: 'class-attendance',
          component: () => import('@/views/apps/classes/ClassAttendanceView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Class Attendance', active: true }
            ],
            pageTitle: 'Class Attendance',
            rule: 'editor'
          }
        },
        {
          path: '/class-subjects/:classId',
          name: 'class-subjects',
          component: () => import('@/views/apps/subjects/manage-subjects/ManageSubject.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Class Subjects', active: true }
            ],
            pageTitle: 'Class Subjects',
            rule: 'editor'
          }
        },
        {
          path: '/events',
          name: 'events',
          component: () => import('@/views/apps/events/manage-events/EventList.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Events', active: true }
            ],
            pageTitle: 'Events',
            rule: 'editor'
          }
        },
        {
          path: '/fee-details/:studentId',
          name: 'fee-details',
          component: () => import('@/views/apps/fee-vouchers/manage-fee-vouchers/StudentFeeVoucher.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Fee Details', active: true }
            ],
            pageTitle: 'Fee Details',
            rule: 'editor'
          }
        },
        {
          path: '/manage-students',
          name: 'manage-students',
          component: () => import('@/views/apps/students/manage-students/ManageStudent.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'students', url: '/manage-students' },
              { title: 'Manage Students', active: true }
            ],
            pageTitle: 'Manage Students',
            rule: 'editor'
          }
        },
        {
          path: '/manage-classes',
          name: 'manage-classes',
          component: () => import('@/views/apps/classes/manage-classes/ManageClass.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Classes', url: '/manage-classes' },
              { title: 'Manage Classes', active: true }
            ],
            pageTitle: 'Manage Classes',
            rule: 'editor'
          }
        },
        {
          path: '/manage-subjects',
          name: 'manage-subjects',
          component: () => import('@/views/apps/subjects/manage-subjects/ManageSubject.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Subjects', url: '/manage-subjects' },
              { title: 'Manage Subjects', active: true }
            ],
            pageTitle: 'Manage Subjects',
            rule: 'editor'
          }
        },
        {
          path: '/profile',
          name: 'profile',
          component: () => import('@/views/pages/Admin.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Pages' },
              { title: 'Profile', active: true }
            ],
            pageTitle: 'Profile',
            rule: 'editor'
          }
        },
        {
          path: '/user-detail/:userId',
          name: 'user-view',
          component: () => import('@/views/apps/user/manage-users/UserDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Users', url: '/manage-users' },
              { title: 'View', active: true }
            ],
            pageTitle: 'User View',
            rule: 'editor'
          }
        },
        {
          path: '/student-detail/:studentId',
          name: 'student-detail',
          component: () => import('@/views/apps/students/manage-students/StudentDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Student Details', active: true }
            ],
            pageTitle: 'Student Details',
            rule: 'editor'
          }
        },
        {
          path: '/mark-attendance/:classId',
          name: 'mark-attendance',
          component: () => import('@/views/apps/classes/manage-classes/MarkAttendance.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Mark Attendance', active: true }
            ],
            pageTitle: 'Mark Attendance',
            rule: 'editor'
          }
        },
        {
          path: '/user-edit/:userId',
          name: 'user-edit',
          component: () => import('@/views/apps/user/manage-users/UserEdit.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Users', url: '/manage-users' },
              { title: 'Edit', active: true }
            ],
            pageTitle: 'Edit User',
            rule: 'editor'
          }
        },
        {
          path: '/student-edit/:studentId',
          name: 'student-edit',
          component: () => import('@/views/apps/students/manage-students/StudentEdit.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Students', url: '/manage-students' },
              { title: 'Edit', active: true }
            ],
            pageTitle: 'Edit Student',
            rule: 'editor'
          }
        },
        {
          path: '/manage-students',
          name: 'manage-students',
          component: () => import('@/views/apps/students/manage-students/ManageStudent.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Students', url: '/manage-students' },
              { title: 'Manage Students', active: true }
            ],
            pageTitle: 'Manage Students',
            rule: 'editor'
          }
        },
        {
          path: '/class-detail/:classId',
          name: 'class-view',
          component: () => import('@/views/apps/classes/manage-classes/ClassDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Classes', url: '/manage-classes' },
              { title: 'View', active: true }
            ],
            pageTitle: 'Class View',
            rule: 'editor'
          }
        },
        {
          path: '/class-edit/:classId',
          name: 'class-edit',
          component: () => import('@/views/apps/classes/manage-classes/ClassEdit.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Classes', url: '/manage-classes' },
              { title: 'Edit', active: true }
            ],
            pageTitle: 'Edit Class',
            rule: 'editor'
          }
        },
        {
          path: '/subject-detail/:subjectId',
          name: 'subject-view',
          component: () => import('@/views/apps/subjects/manage-subjects/SubjectDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Subjects', url: '/manage-subjects' },
              { title: 'View', active: true }
            ],
            pageTitle: 'Subject View',
            rule: 'editor'
          }
        },
        {
          path: '/subject-edit/:subjectId',
          name: 'subject-edit',
          component: () => import('@/views/apps/subjects/manage-subjects/SubjectEdit.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Subjects', url: '/manage-subjects' },
              { title: 'Edit', active: true }
            ],
            pageTitle: 'Edit Subject',
            rule: 'editor'
          }
        },
        {
          path: '/subject-marks/:classId',
          name: 'subject-marks',
          component: () => import('@/views/apps/subjects/manage-subjects/SubjectMarks.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Subjects', url: '/subject-marks' },
              { title: 'Subject Marks', active: true }
            ],
            pageTitle: 'Subject Marks',
            rule: 'editor'
          }
        },
        {
          path: '/class-assignments/:classId',
          name: 'class-assignments',
          component: () => import('@/views/apps/assignments/manage-assignments/ManageAssignment.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Class', url: '/manage-classes' },
              { title: 'Class Homework', active: true }
            ],
            pageTitle: 'Class Homework',
            rule: 'editor'
          }
        },
        {
          path: '/assignment-detail/:assignmentId',
          name: 'assignment-detail',
          component: () => import('@/views/apps/assignments/manage-assignments/AssignmentDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Class', url: '/manage-assignments' },
              { title: 'Homework Details', active: true }
            ],
            pageTitle: 'Homework Details',
            rule: 'editor'
          }
        },
        {
          path: '/assignments/:studentId',
          name: 'assignments',
          component: () => import('@/views/apps/assignments/manage-assignments/StudentAssignments.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Class', url: '/manage-assignments' },
              { title: 'Homework Details', active: true }
            ],
            pageTitle: 'Homework Details',
            rule: 'editor'
          }
        },
        {
          path: '/subject-syllabus/:classId',
          name: 'subject-syllabus',
          component: () => import('@/views/apps/subjects/manage-subjects/SubjectSyllabus.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Subjects', url: '/subject-marks' },
              { title: 'Subject Syllabus', active: true }
            ],
            pageTitle: 'Subject Syllabus',
            rule: 'editor'
          }
        },
        {
          path: '/create-session',
          name: 'create-session',
          component: () => import('@/views/apps/sessions/SessionCreate.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Sessions', url: '/manage-sessions' },
              { title: 'Create', active: true }
            ],
            pageTitle: 'Create Session',
            rule: 'editor'
          }
        },
        {
          path: '/manage-sessions',
          name: 'manage-sessions',
          component: () => import('@/views/apps/sessions/manage-sessions/ManageSession.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Sessions', url: '/manage-sessions' },
              { title: 'Manage Sessions', active: true }
            ],
            pageTitle: 'Manage Sessions',
            rule: 'editor'
          }
        },
        {
          path: '/session-detail/:sessionId',
          name: 'session-view',
          component: () => import('@/views/apps/sessions/manage-sessions/SessionDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Sessions', url: '/manage-sessions' },
              { title: 'View', active: true }
            ],
            pageTitle: 'Session View',
            rule: 'editor'
          }
        },
        {
          path: '/session-edit/:sessionId',
          name: 'session-edit',
          component: () => import('@/views/apps/sessions/manage-sessions/SessionEdit.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Sessions', url: '/manage-sessions' },
              { title: 'Edit', active: true }
            ],
            pageTitle: 'Edit Session',
            rule: 'editor'
          }
        },
        {
          path: '/create-syllabus',
          name: 'create-syllabus',
          component: () => import('@/views/apps/syllabuses/SyllabusCreate.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Syllabuses', url: '/manage-syllabuses' },
              { title: 'Create', active: true }
            ],
            pageTitle: 'Create Syllabus',
            rule: 'editor'
          }
        },
        {
          path: '/manage-syllabuses',
          name: 'manage-syllabuses',
          component: () => import('@/views/apps/syllabuses/manage-syllabuses/ManageSyllabus.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Syllabuses', url: '/manage-syllabuses' },
              { title: 'Manage Syllabuses', active: true }
            ],
            pageTitle: 'Manage Syllabuses',
            rule: 'editor'
          }
        },
        {
          path: '/syllabus-detail/:syllabusId',
          name: 'syllabus-view',
          component: () => import('@/views/apps/syllabuses/manage-syllabuses/SyllabusDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Syllabuses', url: '/manage-syllabuses' },
              { title: 'View', active: true }
            ],
            pageTitle: 'Syllabus View',
            rule: 'editor'
          }
        },
        {
          path: '/syllabus-edit/:syllabusId',
          name: 'syllabus-edit',
          component: () => import('@/views/apps/syllabuses/manage-syllabuses/SyllabusEdit.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Syllabuses', url: '/manage-syllabuses' },
              { title: 'Edit', active: true }
            ],
            pageTitle: 'Edit Syllabus',
            rule: 'editor'
          }
        },
        {
          path: '/accountant-detail/:accountantId',
          name: 'accountant-view',
          component: () => import('@/views/apps/accountants/manage-accountants/AccountantDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Accountants', url: '/manage-accountants' },
              { title: 'View', active: true }
            ],
            pageTitle: 'Accounatant View',
            rule: 'editor'
          }
        },
        {
          path: '/accountant-edit/:accountantId',
          name: 'accountant-edit',
          component: () => import('@/views/apps/accountants/manage-accountants/AccountantEdit.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Accountants', url: '/manage-accountants' },
              { title: 'Edit', active: true }
            ],
            pageTitle: 'Edit Accounatant',
            rule: 'editor'
          }
        },
        {
          path: '/subadmin-detail/:adminId',
          name: 'subadmin-view',
          component: () => import('@/views/apps/subadmins/SubAdminView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Sub Admins', url: '/manage-subadmins' },
              { title: 'View', active: true }
            ],
            pageTitle: 'User View',
            rule: 'editor'
          }
        },
        {
          path: '/subadmin-edit/:adminId',
          name: 'subadmin-edit',
          component: () => import('@/views/apps/subadmins/subadmin-edit/SubAdminEdit.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Sub Admins', url: '/manage-subadmins' },
              { title: 'Edit', active: true }
            ],
            pageTitle: 'Edit User',
            rule: 'editor'
          }
        },
        {
          path: '/create-subadmin',
          name: 'create-subadmin',
          component: () => import('@/views/apps/subadmins/SubAdminCreate.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Sub Admins', url: '/manage-subadmins' },
              { title: 'Create', active: true }
            ],
            pageTitle: 'Create Sub Admin',
            rule: 'editor'
          }
        },
        {
          path: '/create-accountant',
          name: 'create-accountant',
          component: () => import('@/views/apps/accountants/AccountantCreate.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Accountants', url: '/manage-accountants' },
              { title: 'Create', active: true }
            ],
            pageTitle: 'Create Accountant',
            rule: 'editor'
          }
        },
        {
          path: '/create-teacher',
          name: 'create-teacher',
          component: () => import('@/views/apps/teachers/TeacherCreate.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Teacher', url: '/manage-teachers' },
              { title: 'Create', active: true }
            ],
            pageTitle: 'Create Teacher',
            rule: 'editor'
          }
        },
        {
          path: '/create-student',
          name: 'create-student',
          component: () => import('@/views/apps/students/StudentCreate.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Students', url: '/manage-students' },
              { title: 'Create', active: true }
            ],
            pageTitle: 'Create Student',
            rule: 'editor'
          }
        },
        {
          path: '/create-class',
          name: 'create-class',
          component: () => import('@/views/apps/classes/ClassCreate.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Classes', url: '/manage-classes' },
              { title: 'Create', active: true }
            ],
            pageTitle: 'Create Class',
            rule: 'editor'
          }
        },
        {
          path: '/create-subject',
          name: 'create-subject',
          component: () => import('@/views/apps/subjects/SubjectCreate.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Subjects', url: '/manage-subjects' },
              { title: 'Create', active: true }
            ],
            pageTitle: 'Create Subject',
            rule: 'editor'
          }
        },
        {
          path: '/custom-view',
          name: 'custom-view',
          component: () => import('@/views/apps/view/customView.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Items' },
              { title: 'Sold Items', active: true }
            ],
            pageTitle: 'Custom View',
            rule: 'editor'
          }
        },
        {
          path: '/contact-queries',
          name: 'contact-queries',
          component: () => import('@/views/apps/queries/ContactQueries.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Contact Queries', active: true }
            ],
            pageTitle: 'Contact Queries',
            rule: 'editor'
          }
        },
        {
          path: '/query-detail/:queryId',
          name: 'query-detail',
          component: () => import('@/views/apps/queries/QueryDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Queries', url: '/contact-queries' },
              { title: 'Query Details', active: true }
            ],
            pageTitle: 'Query Details',
            rule: 'editor'
          }
        },
        {
          path: '/manage-timetables',
          name: 'manage-timetables',
          component: () => import('@/views/apps/timetables/manage-timetables/ManageTimeTable.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Timetables', url: '/manage-timetables' },
              { title: 'Manage Timetables', active: true }
            ],
            pageTitle: 'Manage Timetables',
            rule: 'editor' || 'student'
          }
        },
        {
          path: '/timetable-detail/:timetableId',
          name: 'timetable-detail',
          component: () => import('@/views/apps/timetables/manage-timetables/TimeTableDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Timetables', url: '/manage-timetables' },
              { title: 'View', active: true }
            ],
            pageTitle: 'Timetable Details',
            rule: 'editor'
          }
        },
        {
          path: '/create-timetable',
          name: 'create-timetable',
          component: () => import('@/views/apps/timetables/TimeTableCreate.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Timetables', url: '/manage-timetables' },
              { title: 'Create Timetable', active: true }
            ],
            pageTitle: 'Create Timetable',
            rule: 'editor' || 'student'
          }
        },
        {
          path: '/timetable-edit/:timetableId',
          name: 'timetable-edit',
          component: () => import('@/views/apps/timetables/manage-timetables/TimeTableEdit.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Timetables', url: '/manage-timetables' },
              { title: 'Edit', active: true }
            ],
            pageTitle: 'Edit Timetable',
            rule: 'editor'
          }
        },
        {
          path: '/manage-events',
          name: 'manage-events',
          component: () => import('@/views/apps/events/manage-events/ManageEvent.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Events', url: '/manage-events' },
              { title: 'Manage Events', active: true }
            ],
            pageTitle: 'Manage Events',
            rule: 'editor'
          }
        },
        {
          path: '/create-event',
          name: 'create-event',
          component: () => import('@/views/apps/events/EventCreate.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Events', url: '/manage-events' },
              { title: 'Create Event', active: true }
            ],
            pageTitle: 'Create Event',
            rule: 'editor' || 'subadmin'
          }
        },
        {
          path: '/event-edit/:eventId',
          name: 'event-edit',
          component: () => import('@/views/apps/events/manage-events/EventEdit.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Events', url: '/manage-events' },
              { title: 'Edit', active: true }
            ],
            pageTitle: 'Edit Event',
            rule: 'editor'
          }
        },
        {
          path: '/event-detail/:eventId',
          name: 'event-detail',
          component: () => import('@/views/apps/events/manage-events/EventDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Events', url: '/manage-events' },
              { title: 'View', active: true }
            ],
            pageTitle: 'Event Details',
            rule: 'editor'
          }
        },
        {
          path: '/manage-account',
          name: 'manage-account',
          component: () => import('@/views/pages/user-settings/UserSettings.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Account' },
              { title: 'Profile Settings', active: true }
            ],
            pageTitle: 'Settings',
            rule: 'editor'
          }
        },
        {
          path: '/create-fee',
          name: 'create-fee',
          component: () => import('@/views/apps/tuition-fees/TuitionFeeCreate.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Tuition Fees', url: '/manage-tuition-fees' },
              { title: 'Create', active: true }
            ],
            pageTitle: 'Create Fee',
            rule: 'editor'
          }
        },
        {
          path: '/manage-tuition-fees',
          name: 'manage-tuition-fees',
          component: () => import('@/views/apps/tuition-fees/manage-tuition-fees/ManageTuitionFee.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Tuition Fees', url: '/manage-tuition-fees' },
              { title: 'Manage Tuition Fees', active: true }
            ],
            pageTitle: 'Manage Tuition Fees',
            rule: 'editor'
          }
        },
        {
          path: '/charges-detail/:chargeId',
          name: 'charges-view',
          component: () => import('@/views/apps/tuition-fees/manage-tuition-fees/TuitionFeeDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Tuition Fees', url: '/manage-tuition-fees' },
              { title: 'View', active: true }
            ],
            pageTitle: 'Tuition Fee View',
            rule: 'editor'
          }
        },
        {
          path: '/charges-edit/:chargeId',
          name: 'charges-edit',
          component: () => import('@/views/apps/tuition-fees/manage-tuition-fees/TuitionFeeEdit.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Tuition Fees', url: '/manage-tuition-fees' },
              { title: 'Edit', active: true }
            ],
            pageTitle: 'Edit Tuition Fee',
            rule: 'editor'
          }
        },
        {
          path: '/create-fee-voucher',
          name: 'create-fee-voucher',
          component: () => import('@/views/apps/fee-vouchers/FeeVoucherCreate.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Fee Vouchers', url: '/manage-fee-vouchers' },
              { title: 'Create Fee Voucher', active: true }
            ],
            pageTitle: 'Create Fee Voucher',
            rule: 'editor'
          }
        },
        {
          path: '/manage-fee-vouchers',
          name: 'manage-fee-vouchers',
          component: () => import('@/views/apps/fee-vouchers/manage-fee-vouchers/ManageFeeVoucher.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Manage Fee Vouchers', active: true }
            ],
            pageTitle: 'Manage Fee Vouchers',
            rule: 'editor'
          }
        },
        {
          path: '/fee-voucher-detail/:feeVoucherId',
          name: 'fee-voucher-view',
          component: () => import('@/views/apps/fee-vouchers/manage-fee-vouchers/FeeVoucherDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Manage Fee Vouchers', url: '/manage-fee-vouchers' },
              { title: 'View', active: true }
            ],
            pageTitle: 'Fee Voucher View',
            rule: 'editor'
          }
        },
        {
          path: '/charges-edit/:feeVoucherId',
          name: 'charges-edit',
          component: () => import('@/views/apps/fee-vouchers/manage-fee-vouchers/FeeVoucherEdit.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Manage Fee Vouchers', url: '/manage-fee-vouchers' },
              { title: 'Edit', active: true }
            ],
            pageTitle: 'Edit Fee Voucher',
            rule: 'editor'
          }
        },
        {
          path: '/manage-scheduled-exams',
          name: 'manage-exams',
          component: () => import('@/views/apps/exams/manage-exams/ManageExam.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Manage Exams', active: true }
            ],
            pageTitle: 'Manage Exams',
            rule: 'editor' || 'student'
          }
        },
        {
          path: '/exam-detail/:examId',
          name: 'exam-detail',
          component: () => import('@/views/apps/exams/manage-exams/ExamDetail.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Exams', url: '/manage-scheduled-exams' },
              { title: 'View', active: true }
            ],
            pageTitle: 'Exam Details',
            rule: 'editor'
          }
        },
        {
          path: '/exam-students/:examId/:classId',
          name: 'exam-students',
          component: () => import('@/views/apps/exams/manage-exams/ExamStudent.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Exams', url: '/manage-scheduled-exams' },
              { title: 'View', active: true }
            ],
            pageTitle: 'Exam Details',
            rule: 'editor'
          }
        },
        {
          path: '/report-card/:studentId',
          name: 'report-card',
          component: () => import('@/views/apps/exams/manage-exams/ReportCard.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Exams', url: '/manage-scheduled-exams' },
              { title: 'View', active: true }
            ],
            pageTitle: 'Report Card',
            rule: 'editor'
          }
        },
        {
          path: '/download-report-card/:examId/:studentId',
          name: 'download-report-card',
          component: () => import('@/views/apps/exams/manage-exams/Invoice.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Exams', url: '/manage-scheduled-exams' },
              { title: 'View', active: true }
            ],
            pageTitle: 'Report Card',
            rule: 'editor'
          }
        },
        {
          path: '/schedule-exam',
          name: 'schedule-exam',
          component: () => import('@/views/apps/exams/ExamCreate.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Exams', url: '/manage-scheduled-exams' },
              { title: 'Schedule An Exam', active: true }
            ],
            pageTitle: 'Schedule An Exam',
            rule: 'editor' || 'student'
          }
        },
        {
          path: '/exam-edit/:examId',
          name: 'exam-edit',
          component: () => import('@/views/apps/exams/manage-exams/ExamEdit.vue'),
          meta: {
            breadcrumb: [
              { title: 'Home', url: '/' },
              { title: 'Exams', url: '/manage-scheduled-exams' },
              { title: 'Edit', active: true }
            ],
            pageTitle: 'Edit Exam',
            rule: 'editor'
          }
        },
      ]
    },
    {
      // =============================================================================
      // MAIN LAYOUT ROUTES
      // =============================================================================
      path: '',
      component: () => import('./layouts/main/Main.vue'),
      children: [
        // =============================================================================
        // Theme Routes
        // =============================================================================
        {
          path: '/',
          redirect: '/home'
        },
      ]
    },
    // =============================================================================
    // FULL PAGE LAYOUTS
    // =============================================================================
    {
      path: '',
      component: () => import('@/layouts/full-page/FullPage.vue'),
      children: [
        // =============================================================================
        // PAGES
        // =============================================================================
        {
          path: '/login',
          name: 'login',
          component: () => import('@/views/pages/login/Login.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/comingsoon',
          name: 'page-coming-soon',
          component: () => import('@/views/pages/ComingSoon.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/error-404',
          name: 'page-error-404',
          component: () => import('@/views/pages/Error404.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/error-500',
          name: 'page-error-500',
          component: () => import('@/views/pages/Error500.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/not-authorized',
          name: 'page-not-authorized',
          component: () => import('@/views/pages/NotAuthorized.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/maintenance',
          name: 'page-maintenance',
          component: () => import('@/views/pages/Maintenance.vue'),
          meta: {
            rule: 'editor'
          }
        },
      ]
    },
    // Redirect to 404 page, if no match found
    {
      path: '*',
      redirect: '/pages/error-404'
    }
  ]
})

router.afterEach(() => {
  console.log('afterEach');
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = 'none'
  }
})
router.beforeEach((to, from, next) => {
  if (to.name !== 'login' && !(localStorage.getItem("userInfo"))) next({ name: 'login' })
  else if ((to.name === 'login') && (localStorage.getItem("userInfo"))) next({ name: 'home' })
  else next()
})
export default router
