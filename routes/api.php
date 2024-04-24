<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
  Route::post('/logout', 'API\AuthController@logout');
});
Route::any('/v1/register', ['as' => 'register', 'uses' => 'API\V1\RegisterController@register']);
Route::any('/v1/login', ['as' => 'login', 'uses' => 'API\V1\LoginController@login']);
Route::any('/v1/forgot-password', ['as' => 'forgot.password', 'uses' => 'API\V1\LoginController@forgotPassword']);
Route::any('/auth/login', ['as' => 'auth.login', 'uses' => 'API\V1\LoginController@Weblogin']);


Route::any('/user-gain', ['as' => 'user.gain', 'uses' => 'API\V1\DashboardController@userGained']);

// Route::group(['middleware' => ['jwt.verify']], static function ($router) {
Route::any('/v1/fetch-user/{id}', ['as' => 'fetch.user', 'uses' => 'API\V1\UserController@fetchUser']);
Route::any('/v1/update-profile/{id}', ['as' => 'update.profile', 'uses' => 'API\V1\UserController@updateprofile']);
Route::any('/v1/app-update-profile', ['as' => 'app.update.profile', 'uses' => 'API\V1\UserController@appUpdateprofile']);
Route::any('/v1/reset-password', ['as' => 'reset.password', 'uses' => 'API\V1\UserController@resetPassword']);
Route::any('/v1/logout', ['as' => 'logout', 'uses' => 'API\V1\UserController@logout']);
Route::any('/auth/logout', ['as' => 'auth.logout', 'uses' => 'API\V1\UserController@Weblogout']);
Route::any('/v1/report-today', ['as' => 'report.today', 'uses' => 'API\V1\DashboardController@reportToday']);
Route::any('/v1/report-week', ['as' => 'report.week', 'uses' => 'API\V1\DashboardController@reportWeek']);
Route::any('/v1/report-month', ['as' => 'report.month', 'uses' => 'API\V1\DashboardController@reportMonth']);
Route::any('/v1/report', ['as' => 'report', 'uses' => 'API\V1\DashboardController@customReport']);
Route::any('/v1/manage-users', ['as' => 'manage.users', 'uses' => 'API\V1\UserController@manageUsers']);
Route::any('/v1/get-teachers', ['as' => 'get.teachers', 'uses' => 'API\V1\UserController@getTeachers']);
Route::any('/v1/get-students', ['as' => 'get.students', 'uses' => 'API\V1\UserController@getStudents']);
Route::any('/v1/get-assigned-students/{id}', ['as' => 'get.assigned.students', 'uses' => 'API\V1\UserController@getAssignedStudents']);
Route::any('/v1/get-subjects', ['as' => 'get.subjects', 'uses' => 'SubjectController@getSubjects']);
Route::any('/v1/get-class-subjects/{id}', ['as' => 'get.class.subjects', 'uses' => 'SubjectController@getClassSubjects']);
Route::any('/v1/get-teacher-subjects', ['as' => 'teacher.subjects', 'uses' => 'SubjectController@getTeacherSubjects']);
Route::any('/v1/get-classes', ['as' => 'get.classes', 'uses' => 'ClassDetailController@getClasses']);
Route::any('/v1/get-events', ['as' => 'get.events', 'uses' => 'EventController@getEvents']);
Route::any('/v1/get-hours', ['as' => 'get.hours', 'uses' => 'TimeTableController@getHours']);
Route::any('/v1/get-days', ['as' => 'get.days', 'uses' => 'TimeTableController@getDays']);
Route::any('/v1/get-months', ['as' => 'months', 'uses' => 'API\V1\UserController@getMonths']);
Route::any('/v1/student-info/{id}', ['as' => 'student.info', 'uses' => 'API\V1\UserController@studentInfo']);
Route::any('/v1/student-detail/{id}', ['as' => 'student.detail', 'uses' => 'API\V1\UserController@fetchStudent']);
Route::any('/v1/teacher-detail/{id}', ['as' => 'teacher.detail', 'uses' => 'API\V1\UserController@fetchTeacher']);
Route::any('/v1/set-password', ['as' => 'set.password', 'uses' => 'API\V1\LoginController@setPassword']);

// SESSION ROUTES
Route::any('/v1/create-session', ['as' => 'create.session', 'uses' => 'SessionController@createSession']);
Route::any('/v1/get-sessions', ['as' => 'get.sessions', 'uses' => 'SessionController@getSessions']);
Route::any('/v1/session-detail/{id}', ['as' => 'session.detail', 'uses' => 'SessionController@fetchSession']);
Route::any('/v1/edit-session/{id}', ['as' => 'update.session', 'uses' => 'SessionController@updateSession']);
Route::any('/v1/delete-session/{id}', ['as' => 'delete.session', 'uses' => 'SessionController@deleteSession']);

// SUBJECTS ROUTES
Route::any('/v1/subject-detail/{id}', ['as' => 'subject.detail', 'uses' => 'SubjectController@fetchSubject']);

// ACCOUNTANT ROUTES
Route::any('/v1/get-accountants', ['as' => 'get.accountants', 'uses' => 'API\V1\UserController@getAccountants']);
Route::any('/v1/accountant-detail/{id}', ['as' => 'accountant.detail', 'uses' => 'API\V1\UserController@fetchAccountant']);
Route::any('/v1/delete-user/{id}', ['as' => 'delete.user', 'uses' => 'API\V1\UserController@deleteUser']);

// CHARGES ROUTES
Route::any('/v1/create-charges', ['as' => 'create.charges', 'uses' => 'FeeDetailController@createCharges']);
Route::any('/v1/get-charges', ['as' => 'get.charges', 'uses' => 'FeeDetailController@getCharges']);
Route::any('/v1/get-only-charges', ['as' => 'get.only.charges', 'uses' => 'FeeDetailController@getOnlyCharges']);
Route::any('/v1/charge-detail/{id}', ['as' => 'charge.detail', 'uses' => 'FeeDetailController@fetchCharge']);
Route::any('/v1/edit-charge/{id}', ['as' => 'update.charge', 'uses' => 'FeeDetailController@updateCharge']);
Route::any('/v1/delete-charge/{id}', ['as' => 'delete.charge', 'uses' => 'FeeDetailController@deleteCharge']);

// TIMETABLE ROUTES
Route::any('/v1/class-timetable/{id}', ['as' => 'class.timetable', 'uses' => 'TimeTableController@classTimetable']);
Route::any('/v1/teacher-timetable/{id}', ['as' => 'teacher.timetable', 'uses' => 'TimeTableController@teacherTimetable']);
Route::any('/v1/student-timetable/{id}', ['as' => 'student.timetable', 'uses' => 'TimeTableController@studentTimetable']);
Route::any('/v1/app-student-timetable/{id}', ['as' => 'student.timetable', 'uses' => 'TimeTableController@appStudentTimetable']);
Route::any('/v1/delete-timetable/{id}', ['as' => 'delete.timetable', 'uses' => 'TimeTableController@deleteTimetable']);

// EXAM ROUTES
Route::any('/v1/create-exam', ['as' => 'create.exam', 'uses' => 'ExamController@createExam']);
Route::any('/v1/get-exams', ['as' => 'get.exams', 'uses' => 'ExamController@getExams']);
Route::any('/v1/get-active-exams', ['as' => 'get.active.exams', 'uses' => 'ExamController@getActiveExams']);
Route::any('/v1/exam-detail/{id}', ['as' => 'exam.detail', 'uses' => 'ExamController@fetchExam']);
Route::any('/v1/edit-exam/{id}', ['as' => 'update.exam', 'uses' => 'ExamController@updateExam']);
Route::any('/v1/delete-exam/{id}', ['as' => 'delete.exam', 'uses' => 'ExamController@deleteExam']);
Route::any('/v1/save-exam-logs', ['as' => 'save.exam.logs', 'uses' => 'ExamLogController@saveExamLog']);
Route::any('/v1/fetch-student-report/{id}', ['as' => 'fetch.student.report', 'uses' => 'SubjectController@fetchStudentReport']);

// ATTENDANCE ROUTES
Route::any('/v1/fetch-student-attendance/{id}', ['as' => 'fetch.student.attendance', 'uses' => 'AttendanceController@fetchStudentAttendance']);
Route::any('/v1/fetch-attendance', ['as' => 'fetch.attendance', 'uses' => 'AttendanceController@fetchAttendance']);
Route::any('/v1/mark-all-present', ['as' => 'mark.present', 'uses' => 'AttendanceController@markAllPresent']);
Route::any('/v1/mark-all-absent', ['as' => 'mark.present', 'uses' => 'AttendanceController@markAllAbsent']);
Route::any('/v1/mark-app-attendance', ['as' => 'mark.app.attendance', 'uses' => 'AttendanceController@markAppAttendance']);

// REPORT CARD ROUTES
Route::any('/v1/generate-report-card', ['as' => 'generate.report.card', 'uses' => 'ReportCardController@generateReportCard']);
Route::any('/v1/report-card/{exam_id}/{id}', ['as' => 'report.card', 'uses' => 'ReportCardController@ReportCard']);

// SYLLABUSES ROUTES
Route::any('/v1/get-class-syllabuses/{id}', ['as' => 'get.class.syllabuses', 'uses' => 'SyllabusController@getClassSyllabus']);
Route::any('/v1/upload-syllabus', ['as' => 'upload.syllabus', 'uses' => 'SyllabusController@uploadSyllabus']);
Route::any('/v1/create-syllabus', ['as' => 'create.syllabus', 'uses' => 'SyllabusController@createSyllabus']);
Route::any('/v1/delete-syllabus/{id}', ['as' => 'delete.syllabus', 'uses' => 'SyllabusController@deleteSyllabus']);

// ASSIGNMENTS ROUTES
Route::any('/v1/get-class-assignments/{id}', ['as' => 'get.class.assignments', 'uses' => 'SyllabusController@getClassAssignments']);
Route::any('/v1/fetch-student-assignments/{id}', ['as' => 'fetch.student.assignments', 'uses' => 'SyllabusController@fetchStudentAssignments']);
Route::any('/v1/create-assignment', ['as' => 'create.assignment', 'uses' => 'SyllabusController@createAssignment']);
Route::any('/v1/assignment-detail/{id}', ['as' => 'assignment.detail', 'uses' => 'SyllabusController@assignmentDetail']);
Route::any('/v1/get-student-assignments/{id}', ['as' => 'student.assignments', 'uses' => 'SyllabusController@getStudentAssignments']);
Route::any('/v1/upload-assignment', ['as' => 'upload.assignment', 'uses' => 'SyllabusController@uploadAssignment']);
Route::any('/v1/upload-aadhar', ['as' => 'upload.aadhar', 'uses' => 'SyllabusController@uploadAadhar']);
Route::any('/v1/check-assignment', ['as' => 'check.assignment', 'uses' => 'SyllabusController@checkAssignment']);

// FEE VOUCHER ROUTES
Route::any('/v1/create-fee-voucher', ['as' => 'create.fee.voucher', 'uses' => 'FeeVoucherController@createFeeVoucher']);
Route::any('/v1/fetch-fee-vouchers', ['as' => 'fetch.fee.vouchers', 'uses' => 'FeeVoucherController@fetchFeeVouchers']);
Route::any('/v1/fetch-student-fee-vouchers/{student_id}', ['as' => 'fetch.student.fee.vouchers', 'uses' => 'FeeVoucherController@fetchStudentFeeVouchers']);
Route::any('/v1/get-voucher-detail/{id}', ['as' => 'get.voucher.detail', 'uses' => 'FeeVoucherController@getVoucherDetail']);
Route::any('/v1/pay-now', ['as' => 'pay.now', 'uses' => 'FeeVoucherController@payment']);
Route::any('/v1/save-payment', ['as' => 'save.payment', 'uses' => 'FeeVoucherController@savePayment']);
Route::any('/v1/cash-payment', ['as' => 'cash.payment', 'uses' => 'FeeVoucherController@cashPayment']);
// });
Route::any('/reset/password', ['as' => 'reset.confirm', 'uses' => 'API\V1\LoginController@resetPasswordConfirm']);
Route::any('/v1/update-password', ['as' => 'update.password', 'uses' => 'API\V1\LoginController@updatePassword']);


Route::group(['middleware' => ['my.cors']],  function () {
  Route::any('/v1/contact-us', ['as' => 'contact', 'uses' => 'ContactController@contact']);
  Route::any('/v1/get-syllabuses', ['as' => 'get.syllabuses', 'uses' => 'SyllabusController@getSyllabus']);
});

Route::any('/v1/send-mail', ['as' => 'mail', 'uses' => 'ContactController@mail']);
Route::any('/contact-queries', ['as' => 'contact.queries', 'uses' => 'ContactController@contactQueries']);
Route::any('/fetch-query/{id}', ['as' => 'fetch.query', 'uses' => 'ContactController@fetchQuery']);

// SUBADMIN APIS
Route::any('/v1/create-subadmin', ['as' => 'create.subadmin', 'uses' => 'API\V1\UserController@createSubadmin']);
Route::any('/v1/create-accountant', ['as' => 'create.accountant', 'uses' => 'API\V1\UserController@createAccountant']);
Route::any('/v1/create-teacher', ['as' => 'create.teacher', 'uses' => 'API\V1\UserController@createTeacher']);
Route::any('/v1/create-student', ['as' => 'create.student', 'uses' => 'API\V1\UserController@createStudent']);
Route::any('/v1/create-class', ['as' => 'create.class', 'uses' => 'ClassDetailController@createClass']);
Route::any('/v1/edit-class/{id}', ['as' => 'update.class', 'uses' => 'ClassDetailController@updateClass']);
Route::any('/v1/delete-class/{id}', ['as' => 'delete.class', 'uses' => 'ClassDetailController@destroy']);
Route::any('/v1/create-subject', ['as' => 'create.subject', 'uses' => 'SubjectController@createSubject']);
Route::any('/v1/edit-subject/{id}', ['as' => 'update.subject', 'uses' => 'SubjectController@updateSubject']);
Route::any('/v1/delete-subject/{id}', ['as' => 'delete.subject', 'uses' => 'SubjectController@destroy']);

// ADMIN APIS
Route::any('/v1/get-students-by-class/{class_id}', ['as' => 'get.students.class', 'uses' => 'ClassDetailController@getStudentByClass']);
Route::any('/v1/get-assigned-classes/{teacher_id}', ['as' => 'get.assigned.classes', 'uses' => 'ClassDetailController@getAssignedClasses']);
Route::any('/v1/get-subject-classes/{teacher_id}', ['as' => 'get.subject.classes', 'uses' => 'ClassDetailController@getSubjectClasses']);
Route::any('/v1/update-student/{id}', ['as' => 'update.student', 'uses' => 'API\V1\UserController@updateStudent']);
Route::any('/v1/event-detail/{id}', ['as' => 'event.detail', 'uses' => 'EventController@fetchEvent']);
Route::any('/v1/class-detail/{id}', ['as' => 'class.detail', 'uses' => 'ClassDetailController@fetchClass']);
Route::any('/v1/initiate-payment', ['as' => 'initiate.payment', 'uses' => 'FeePaymentController@initiate']);

// Assign Fee to Class
Route::any('/v1/fetch-monthly-fee/{id}', ['as' => 'fetch.monthly', 'uses' => 'ClassFeeDetailController@fetchMonthlyFee']);
Route::any('/v1/update-fee', ['as' => 'update.fee', 'uses' => 'ClassFeeDetailController@updateFee']);

// TIMETABLE APIS
Route::any('/v1/get-timetables', ['as' => 'get.timetables', 'uses' => 'TimeTableController@getTimeTables']);
Route::any('/v1/create-timetable', ['as' => 'create.timetable', 'uses' => 'TimeTableController@createTimeTable']);
Route::any('/v1/timetable-detail/{id}', ['as' => 'timetable.detail', 'uses' => 'TimeTableController@getTimeTableDetail']);
Route::any('/v1/update-timetable/{id}', ['as' => 'update.timetable', 'uses' => 'TimeTableController@updateTimetable']);


Route::any('/v1/create-event', ['as' => 'create.event', 'uses' => 'EventController@createEvent']);
Route::any('/v1/upload', ['as' => 'upload', 'uses' => 'EventController@upload']);
Route::any('/v1/assignment', ['as' => 'assignment', 'uses' => 'EventController@assignment']);
Route::any('/v1/update-event/{id}', ['as' => 'update.event', 'uses' => 'EventController@updateEvent']);
Route::any('/v1/approve-event/{id}', ['as' => 'approve.event', 'uses' => 'EventController@approveEvent']);
Route::any('/v1/remove-event/{id}', ['as' => 'remove.event', 'uses' => 'EventController@removeEvent']);
Route::any('/v1/get-record/{hour_id}/{day_id}/{teacher_id}', ['as' => 'get.record', 'uses' => 'TimeTableController@getRecord']);


// Attendance routes

Route::any('/v1/mark-attendance', ['as' => 'mark.attendance', 'uses' => 'AttendanceController@markAttendance']);
Route::any('/v1/check-attendance', ['as' => 'check.attendance', 'uses' => 'AttendanceController@checkAttendance']);

Route::any('/v1/import-students', ['as' => 'import.students', 'uses' => 'ImportController@update']);
