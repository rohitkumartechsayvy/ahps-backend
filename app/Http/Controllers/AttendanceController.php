<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ClassIncharge;
use App\Models\StudentSchoolStatus;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DB;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function fetchAttendance(Request $request)
  {
    $class_students = DB::table('student_school_statuses')->where('class_id', $request->class_id)->where('status', 'active')->get();
    $students = [];
    $data = [];
    $from = Carbon::parse($request->from_date)
      ->startOfDay()        // 2018-09-29 00:00:00.000000
      ->toDateTimeString(); // 2018-09-29 00:00:00

    $to = Carbon::parse($request->to_date)
      ->endOfDay()          // 2018-09-29 23:59:59.000000
      ->toDateTimeString();
    if (isset($class_students) && count($class_students) > 0) {
      foreach ($class_students as $key => $value) {
        $students[] = $value->student_id;
      }
    }
    if (isset($students) && count($students) > 0) {
      foreach ($students as $student_key => $student) {
        $student_obj = [];
        $student_obj['student_id'] = $student;
        $student_obj['name'] = User::where('id', $student)->value('name');
        $student_obj['total'] = DB::table('attendances')->select('*', 'attendances.id as id', 'attendances.status as attendance_status')->join('users', 'users.id', 'attendances.student_id')->where('attendances.class_id', $request->class_id)->where('attendances.student_id', $student)->whereBetween('attendances.date', [$from, $to])->count();



        $student_obj['present'] = DB::table('attendances')->select('*', 'attendances.id as id', 'attendances.status as attendance_status')->join('users', 'users.id', 'attendances.student_id')->where('attendances.class_id', $request->class_id)->where('attendances.student_id', $student)->where('attendances.status', 'present')->whereDate('attendances.date', '>=', $request->from_date)->whereDate('attendances.date', '<=', $request->to_date)->count();
        $student_obj['absent'] = DB::table('attendances')->select('*', 'attendances.id as id', 'attendances.status as attendance_status')->join('users', 'users.id', 'attendances.student_id')->where('attendances.class_id', $request->class_id)->where('attendances.student_id', $student)->where('attendances.status', 'absent')->whereDate('attendances.date', '>=', $request->from_date)->whereDate('attendances.date', '<=', $request->to_date)->count();
        $student_obj['leave'] = DB::table('attendances')->select('*', 'attendances.id as id', 'attendances.status as attendance_status')->join('users', 'users.id', 'attendances.student_id')->where('attendances.class_id', $request->class_id)->where('attendances.student_id', $student)->where('attendances.status', 'leave')->whereDate('attendances.date', '>=', $request->from_date)->whereDate('attendances.date', '<=', $request->to_date)->count();
        $student_obj['half_day'] = DB::table('attendances')->select('*', 'attendances.id as id', 'attendances.status as attendance_status')->join('users', 'users.id', 'attendances.student_id')->where('attendances.class_id', $request->class_id)->where('attendances.student_id', $student)->where('attendances.status', 'half_day')->whereDate('attendances.date', '>=', $request->from_date)->whereDate('attendances.date', '<=', $request->to_date)->count();
        $data[] = $student_obj;
      }
    }
    return apiResponse(200, lang("Attendance Fetched Successfully!"), null, $data);
  }

  public function fetchStudentAttendance($student_id)
  {
    $class_id = DB::table('student_school_statuses')->where('student_id', $student_id)->where('status', 'active')->value('class_id');
    $attendances = Attendance::where('student_id', $student_id)->where('class_id', $class_id)->get();
    $data['attendanceData'] = [];
    $data['present'] = Attendance::where('student_id', $student_id)->where('class_id', $class_id)->where('status', 'present')->get();
    $data['absent'] = Attendance::where('student_id', $student_id)->where('class_id', $class_id)->where('status', 'absent')->get();
    $data['leave'] = Attendance::where('student_id', $student_id)->where('class_id', $class_id)->where('status', 'leave')->get();
    $data['present_count'] = Attendance::where('student_id', $student_id)->where('class_id', $class_id)->where('status', 'present')->count();
    $data['absent_count'] = Attendance::where('student_id', $student_id)->where('class_id', $class_id)->where('status', 'absent')->count();
    $data['leave_count'] = Attendance::where('student_id', $student_id)->where('class_id', $class_id)->where('status', 'leave')->count();
    if (isset($attendances) && count($attendances) > 0) {
      foreach ($attendances as $key => $value) {
        $obj = [];
        $obj['id'] = $value->id;
        $obj['startDate'] = Carbon::parse($value->date);
        $obj['endDate'] = Carbon::parse($value->date);
        $obj['url'] = '';
        $obj['classes'] = $value->status && $value->status == 'present' ? 'event-success' : ($value->status && $value->status == 'absent' ? 'event-danger' : ($value->status && $value->status == 'leave' ? 'event-warning' : ""));
        $obj['label'] = $value->status;
        $obj['title'] = Str::ucfirst($value->status);
        $data['attendanceData'][] = $obj;
      }
    }
    $data['total'] = count($data['attendanceData']);
    return apiResponse(200, lang("Student's Attendance Fetched Successfully!"), null, $data);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function markAttendance(Request $request)
  {
    $get_records = [];
    if (isset($request->attendance) && count($request->attendance) > 0) {
      foreach ($request->attendance as $key => $value) {
        $get_record = Attendance::where('student_id', $key)->where('class_id', $request->class_id)->whereDate('date', date('Y-m-d', $request->date))->first();
        if (!$get_record) {
          $data = [];
          $data['student_id'] = $key;
          $data['class_id'] = $request->class_id;
          $data['date'] = Carbon::createFromTimestamp($request->date);
          $data['status'] = $value == 'present' ? 2 : ($value == 'absent' ? 1 : ($value == 'leave' ? 3 : ($value == 'half_day' ? 4 : null)));
          $get_records[] = Attendance::create($data);
        }
      }
    }
    if (isset($get_records) && ($get_records) > 0) {
      return apiResponse(200, lang('Attendance Marked Successfully!'), null, $get_records);
    } else {
      return apiResponse(200, lang('Nothing To Mark!'), null, $get_records);
    }
  }

  public function markAppAttendance(Request $request)
  {
    $get_records = [];
    if (isset($request->present) && count($request->present) > 0) {
      foreach ($request->present as $key => $value) {
        $get_record = Attendance::where('student_id', $value)->where('class_id', $request->class_id)->whereDate('date', date('Y-m-d'))->first();
        if (!$get_record) {
          $data = [];
          $data['student_id'] = $value;
          $data['class_id'] = $request->class_id;
          $data['date'] = date('Y-m-d h:i:s');
          $data['status'] = 2;
          $get_records[] = Attendance::create($data);
        }
      }
    }
    if (isset($request->absent) && count($request->absent) > 0) {
      foreach ($request->absent as $absent_key => $absent_value) {
        $get_record = Attendance::where('student_id', $absent_value)->where('class_id', $request->class_id)->whereDate('date', date('Y-m-d'))->first();
        if (!$get_record) {
          $data = [];
          $data['student_id'] = $absent_value;
          $data['class_id'] = $request->class_id;
          $data['date'] = date('Y-m-d h:i:s');
          $data['status'] = 1;
          $get_records[] = Attendance::create($data);
        }
      }
    }
    if (isset($request->half_day) && count($request->half_day) > 0) {
      foreach ($request->half_day as $half_day_key => $half_day_value) {
        $get_record = Attendance::where('student_id', $half_day_value)->where('class_id', $request->class_id)->whereDate('date', date('Y-m-d'))->first();
        if (!$get_record) {
          $data = [];
          $data['student_id'] = $half_day_value;
          $data['class_id'] = $request->class_id;
          $data['date'] = date('Y-m-d h:i:s');
          $data['status'] = 4;
          $get_records[] = Attendance::create($data);
        }
      }
    }
    if (isset($request->leave) && count($request->leave) > 0) {
      foreach ($request->leave as $leave_key => $leave_value) {
        $get_record = Attendance::where('student_id', $leave_value)->where('class_id', $request->class_id)->whereDate('date', date('Y-m-d'))->first();
        if (!$get_record) {
          $data = [];
          $data['student_id'] = $leave_value;
          $data['class_id'] = $request->class_id;
          $data['date'] = date('Y-m-d h:i:s');
          $data['status'] = 3;
          $get_records[] = Attendance::create($data);
        }
      }
    }
    if (isset($get_records) && ($get_records) > 0) {
      return apiResponse(200, lang('Attendance Marked Successfully!'), null, $get_records);
    } else {
      return apiResponse(200, lang('Nothing To Mark!'), null, $get_records);
    }
  }

  public function markAllPresent(Request $request)
  {
    $students = StudentSchoolStatus::where('class_id', $request->class_id)->where('status', 1)->get();
    if (isset($students) && count($students) > 0) {
      foreach ($students as $key => $value) {
        $get_record = Attendance::where('student_id', $value->student_id)->where('class_id', $request->class_id)->whereDate('date', date('Y-m-d', $request->date))->first();
        if (!$get_record) {
          $data = [];
          $data['student_id'] = $value->student_id;
          $data['class_id'] = $request->class_id;
          $data['date'] = Carbon::createFromTimestamp($request->date);
          $data['status'] = 2;
          $get_records[] = Attendance::create($data);
        }
      }
    }
    if (isset($get_records) && ($get_records) > 0) {
      return apiResponse(200, lang('Attendance Marked Successfully!'), null, $get_records);
    } else {
      return apiResponse(200, lang('Nothing To Mark!'), null, $get_records);
    }
  }

  public function markAllAbsent(Request $request)
  {
    $students = StudentSchoolStatus::where('class_id', $request->class_id)->where('status', 1)->get();
    if (isset($students) && count($students) > 0) {
      foreach ($students as $key => $value) {
        $get_record = Attendance::where('student_id', $value->student_id)->where('class_id', $request->class_id)->whereDate('date', date('Y-m-d', $request->date))->first();
        if (!$get_record) {
          $data = [];
          $data['student_id'] = $value->student_id;
          $data['class_id'] = $request->class_id;
          $data['date'] = Carbon::createFromTimestamp($request->date);
          $data['status'] = 1;
          $get_records[] = Attendance::create($data);
        }
      }
    }
    if (isset($get_records) && ($get_records) > 0) {
      return apiResponse(200, lang('Attendance Marked Successfully!'), null, $get_records);
    } else {
      return apiResponse(200, lang('Nothing To Mark!'), null, $get_records);
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function checkAttendance(Request $request)
  {
    $data['class_incharge'] = ClassIncharge::checkIncharge($request->teacher_id, $request->class_id);
    $data['attendance_marked'] = Attendance::AttendanceMarked($request->class_id);
    return apiResponse(200, lang('Response Fetched Successfully!'), null, $data);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Attendance  $attendance
   * @return \Illuminate\Http\Response
   */
  public function show(Attendance $attendance)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Attendance  $attendance
   * @return \Illuminate\Http\Response
   */
  public function edit(Attendance $attendance)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Attendance  $attendance
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Attendance $attendance)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Attendance  $attendance
   * @return \Illuminate\Http\Response
   */
  public function destroy(Attendance $attendance)
  {
    //
  }
}
