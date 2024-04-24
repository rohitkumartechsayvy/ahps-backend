<?php

namespace App\Http\Controllers;

use App\Models\ClassDetail;
use App\Models\TimeTable;
use Illuminate\Http\Request;
use App\User;
use App\Models\Subject;
use DB;
use Facade\FlareClient\Time\Time;

class TimeTableController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function getTimeTables()
  {
    $timeTables = TimeTable::fetchTimeTables();
    return apiResponse(200, lang('Timetables Fetched Successfully!'), null, $timeTables);
  }

  public function getHours()
  {
    $hours = DB::table('hours')->get();
    return apiResponse(200, lang('Hours Fetched Successfully!'), null, $hours);
  }

  public function getDays()
  {
    $days = DB::table('days')->get();
    return apiResponse(200, lang('Days Fetched Successfully!'), null, $days);
  }
  public function getTimeTableDetail($id)
  {
    $timeTable = TimeTable::fetchTimeTable($id);
    return apiResponse(200, lang('Timetable Fetched Successfully!'), null, $timeTable);
  }
  public function updateTimetable(Request $request, $id)
  {
    $inputs = $request->all();
    $response = TimeTable::where('id', $id)->update(['teacher_id' => $inputs['teacher_id'], 'subject_id' => $inputs['subject_id']]);
    return apiResponse(200, lang('Timetable Updated Successfully!'), null, $response);
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function createTimeTable(Request $request)
  {
    $inputs = $request->all();
    $response = TimeTable::create($inputs);
    return apiResponse(200, lang('TimeTable Created Successfully!'), null, $response);
  }

  public function classTimetable($class_id)
  {
    $hours = DB::table('hours')->get();
    $days = DB::table('days')->get();
    if (isset($hours) && count($hours) > 0) {
      foreach ($hours as $key => $value) {
        $calendarData[$value->id] = [];
        if (isset($days) && count($days) > 0) {
          foreach ($days as $day_key => $day_value) {
            $timetable = TimeTable::where('day_id', $day_value->id)->where('hour_id', $value->id)->where('class_id', $class_id)->first();
            if ($timetable) {
              array_push($calendarData[$value->id], [
                'time_table_id' => $timetable->id,
                'teacher_id' => $timetable->teacher_id,
                'class_id' => $timetable->class_id,
                'subject_id' => $timetable->subject_id,
                'day' => $day_value->day,
                'hour' => $value->from . '-' . $value->to,
                'class_name'   => ClassDetail::where('id', $timetable->class_id)->value('class_name'),
                'teacher_name' => User::where('id', $timetable->teacher_id)->value('name'),
                'subject_name' => Subject::where('id', $timetable->subject_id)->value('subject_name')
              ]);
            } else {
              array_push($calendarData[$value->id], []);
            }
          }
        }
      }
    }
    return apiResponse(200, lang('TimeTable Data Fetched Successfully!'), null, $calendarData);
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function teacherTimetable($id)
  {
    $hours = DB::table('hours')->get();
    $days = DB::table('days')->get();
    if (isset($hours) && count($hours) > 0) {
      foreach ($hours as $key => $value) {
        $calendarData[$value->id] = [];
        if (isset($days) && count($days) > 0) {
          foreach ($days as $day_key => $day_value) {
            $timetable = TimeTable::where('day_id', $day_value->id)->where('hour_id', $value->id)->where('teacher_id', $id)->first();
            if ($timetable) {
              array_push($calendarData[$value->id], [
                'time_table_id' => $timetable->id,
                'teacher_id' => $timetable->teacher_id,
                'class_id' => $timetable->class_id,
                'subject_id' => $timetable->subject_id,
                'day' => $day_value->day,
                'hour' => $value->from . '-' . $value->to,
                'class_name'   => ClassDetail::where('id', $timetable->class_id)->value('class_name'),
                'teacher_name' => User::where('id', $timetable->teacher_id)->value('name'),
                'subject_name' => Subject::where('id', $timetable->subject_id)->value('subject_name')
              ]);
            } else {
              array_push($calendarData[$value->id], []);
            }
          }
        }
      }
    }
    return apiResponse(200, lang('TimeTable Data Fetched Successfully!'), null, $calendarData);
  }
  public function studentTimetable($id)
  {
    $class_id = DB::table('student_school_statuses')->where('student_id', $id)->where('status', 'active')->value('class_id');
    $hours = DB::table('hours')->get();
    $days = DB::table('days')->get();
    if (isset($hours) && count($hours) > 0) {
      foreach ($hours as $key => $value) {
        $calendarData[$value->id] = [];
        if (isset($days) && count($days) > 0) {
          foreach ($days as $day_key => $day_value) {
            $timetable = TimeTable::where('day_id', $day_value->id)->where('hour_id', $value->id)->where('class_id', $class_id)->first();
            if ($timetable) {
              array_push($calendarData[$value->id], [
                'time_table_id' => $timetable->id,
                'teacher_id' => $timetable->teacher_id,
                'class_id' => $timetable->class_id,
                'subject_id' => $timetable->subject_id,
                'day' => $day_value->day,
                'hour' => $value->from . '-' . $value->to,
                'class_name'   => ClassDetail::where('id', $timetable->class_id)->value('class_name'),
                'teacher_name' => User::where('id', $timetable->teacher_id)->value('name'),
                'subject_name' => Subject::where('id', $timetable->subject_id)->value('subject_name')
              ]);
            } else {
              array_push($calendarData[$value->id], []);
            }
          }
        }
      }
    }
    return apiResponse(200, lang('TimeTable Data Fetched Successfully!'), null, $calendarData);
  }
  public function appStudentTimetable($id)
  {
    $class_id = DB::table('student_school_statuses')->where('student_id', $id)->where('status', 'active')->value('class_id');
    $hours = DB::table('hours')->get();
    $days = DB::table('days')->get();
    if (isset($hours) && count($hours) > 0) {
      foreach ($hours as $key => $value) {
        $calendarData[$value->id] = [];
        if (isset($days) && count($days) > 0) {
          foreach ($days as $day_key => $day_value) {
            $timetable = TimeTable::where('day_id', $day_value->id)->where('hour_id', $value->id)->where('class_id', $class_id)->first();
            if ($timetable) {
              array_push($calendarData[$value->id], [
                'time_table_id' => $timetable->id,
                'teacher_id' => $timetable->teacher_id,
                'class_id' => $timetable->class_id,
                'subject_id' => $timetable->subject_id,
                'day' => $day_value->day,
                'hour' => $value->from . '-' . $value->to,
                'class_name'   => ClassDetail::where('id', $timetable->class_id)->value('class_name'),
                'teacher_name' => User::where('id', $timetable->teacher_id)->value('name'),
                'subject_name' => Subject::where('id', $timetable->subject_id)->value('subject_name')
              ]);
            } else {
              array_push($calendarData[$value->id], []);
            }
          }
        }
      }
    }
    return apiResponse(200, lang('TimeTable Data Fetched Successfully!'), null, $calendarData);
  }


  public function getRecord($hour_id, $day_id, $teacher_id)
  {
    $record = TimeTable::fetchRecord($hour_id, $day_id, $teacher_id);
    return apiResponse(200, lang('Record Fetched Successfully!'), null, $record);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\TimeTable  $timeTable
   * @return \Illuminate\Http\Response
   */
  public function show(TimeTable $timeTable)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\TimeTable  $timeTable
   * @return \Illuminate\Http\Response
   */
  public function edit(TimeTable $timeTable)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\TimeTable  $timeTable
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, TimeTable $timeTable)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\TimeTable  $timeTable
   * @return \Illuminate\Http\Response
   */
  public function deleteTimetable($id)
  {
    TimeTable::where('id', $id)->delete();
    return apiResponse(200, lang('Schedule deleted successfully!'), null, null);
  }
}
