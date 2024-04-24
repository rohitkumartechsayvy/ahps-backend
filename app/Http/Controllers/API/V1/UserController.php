<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\ClassIncharge;
use App\Models\FeeDetail;
use App\Models\StudentDetail;
use App\Models\TimeTable;
use App\Models\StudentSchoolStatus;
use App\User;
use Carbon\Carbon;
use DateInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use DB;
use Illuminate\Support\Facades\Date;
use Symfony\Component\VarDumper\Cloner\Data;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use App\Models\Attendance;
use App\Models\ClassDetail;
use App\Models\Subject;

class UserController extends Controller
{
  public function __construct()
  {
    $this->guard = "api";
  }
  public function resetPassword(Request $request)
  {
    $response = [];
    $inputs = $request->all();
    $validator = User::validatePassword($inputs);
    if ($validator->fails()) {
      $messages = implode(",", errorMessages($validator->messages()));
      return json_encode(array("statusCode" => 400, "message" => $messages));
    }
    if (Hash::check($inputs['old_password'], Auth::user()->password)) {
      if (Hash::check($inputs['password'], Auth::user()->password)) {
        return apiResponse(400, lang('Old Password and New password should not match!'), null, null);
      } else {
        $data['password'] = Hash::make($inputs['password']);
        Auth::user()->update($data);
        $credentials['email'] = Auth::user()->email;
        $credentials['password'] = $inputs['password'];
        JWTAuth::invalidate(JWTAuth::getToken());
        $token = JWTAuth::attempt($credentials);
        $response['user_id'] = Auth::user()->id;
        $response['first_name'] = Auth::user()->first_name;
        $response['last_name'] = Auth::user()->last_name;
        $response['company_name'] = Auth::user()->company_name;
        $response['email'] = Auth::user()->email;
        $response['_token'] = $token;
        return apiResponse(200, lang('Password reset successfully!'), null, $response);
      }
    } else {
      return apiResponse(400, lang('Old Password does not match!'), null, null);
    }
  }

  public function logout()
  {
    try {
      auth()->logout();
      JWTAuth::invalidate(JWTAuth::getToken());
      return apiResponse(200, lang('User Logged out successfully!'), null, null);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }
  public function Weblogout()
  {
    try {
      auth()->logout();
      JWTAuth::invalidate(JWTAuth::getToken());
      return apiResponse(200, lang('User Logged out successfully!'), null, null);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }
  public function manageUsers()
  {
    $users['users'] = [];
    $users['subadmins'] = [];
    $users['superadmins'] = [];
    $users['accountants'] = [];
    $users['teachers'] = [];
    $users['students'] = [];
    $users['users'] = User::fetchUsers();
    $users['users_count'] = count(User::fetchUsers());
    $users['subadmins'] = User::fetchSubadmins();
    $users['subadmins_count'] = count(User::fetchSubadmins());
    $users['superadmins'] = User::fetchAdmins();
    $users['superadmins_count'] = count(User::fetchAdmins());
    $users['accountants'] = User::fetchAccountants();
    $users['accountants_count'] = count(User::fetchAccountants());
    $users['teachers'] = User::fetchTeachers();
    $users['teachers_count'] = count(User::fetchTeachers());
    $users['students'] = User::fetchStudents();
    if (isset($users['users']) && count($users['users']) > 0) {
      foreach ($users['users'] as $key => $value) {
        $users['users'][$key]['profile_picture'] = ($users['users'][$key]['profile_picture']) ? url($users['users'][$key]['profile_picture']) : null;
      }
    }
    if (isset($users['subadmins']) && count($users['subadmins']) > 0) {
      foreach ($users['subadmins'] as $key => $value) {
        $users['subadmins'][$key]['profile_picture'] = ($users['subadmins'][$key]['profile_picture']) ? url($users['subadmins'][$key]['profile_picture']) : null;
      }
    }
    if (isset($users['superadmins']) && count($users['superadmins']) > 0) {
      foreach ($users['superadmins'] as $key => $value) {
        $users['superadmins'][$key]['profile_picture'] = ($users['superadmins'][$key]['profile_picture']) ? url($users['superadmins'][$key]['profile_picture']) : null;
      }
    }
    if (isset($users['accountants']) && count($users['accountants']) > 0) {
      foreach ($users['accountants'] as $key => $value) {
        $users['accountants'][$key]['profile_picture'] = ($users['accountants'][$key]['profile_picture']) ? url($users['accountants'][$key]['profile_picture']) : null;
      }
    }
    if (isset($users['teachers']) && count($users['teachers']) > 0) {
      foreach ($users['teachers'] as $key => $value) {
        $users['teachers'][$key]['profile_picture'] = ($users['teachers'][$key]['profile_picture']) ? url($users['teachers'][$key]['profile_picture']) : null;
      }
    }
    if (isset($users['students']) && count($users['students']) > 0) {
      foreach ($users['students'] as $key => $value) {
        $users['students'][$key]['profile_picture'] = ($users['students'][$key]['profile_picture']) ? url($users['students'][$key]['profile_picture']) : null;
        $users['students'][$key]['class_id'] = DB::table('student_school_statuses')->where('student_id', $value->user_id)->where('status', 'active')->value('class_id');
        $users['students'][$key]['class_name'] = ClassDetail::where('id', $users['students'][$key]->class_id)->value('class_name');
      }
    }
    $users['students_count'] = count(User::fetchStudents());
    return apiResponse(200, lang('User Data fetched successfully!'), null, $users);
  }
  public function fetchUser($id)
  {
    $user_details = User::fetchUser($id);
    if (isset($user_details)) {
      $user_details->profile_picture = $user_details->profile_picture ? url($user_details->profile_picture) : null;
      return apiResponse(200, lang('User Data fetched successfully!'), null, $user_details);
    } else {
      return apiResponse(200, lang('No User Data FOund!'), null, null);
    }
  }

  public function fetchAccountant($id)
  {
    $accountant_details = User::fetchUser($id);
    if (isset($accountant_details)) {
      return apiResponse(200, lang('Accountant Data fetched successfully!'), null, $accountant_details);
    } else {
      return apiResponse(200, lang('No Accountant Data FOund!'), null, null);
    }
  }


  public function getTeachers()
  {
    $user_details = User::fetchTeachers();
    if (isset($user_details) && count($user_details) > 0) {
      foreach ($user_details as $key => $value) {
        $user_details[$key]['profile_picture'] = $value->profile_picture ? url($value->profile_picture) : null;
      }
      return apiResponse(200, lang('Teachers fetched successfully!'), null, $user_details);
    } else {
      return apiResponse(200, lang('No User Data FOund!'), null, []);
    }
  }

  public function getStudents()
  {
    $user_details = User::fetchStudents();
    if (isset($user_details) && count($user_details) > 0) {
      foreach ($user_details as $key => $value) {
        $user_details[$key]['profile_picture'] = $value->profile_picture ? url($value->profile_picture) : null;
        $user_details[$key]['class_id'] = DB::table('student_school_statuses')->where('student_id', $user_details[$key]->user_id)->where('status', 'active')->value('class_id');
        $user_details[$key]['class_name'] = ClassDetail::where('id', $user_details[$key]->class_id)->value('class_name');
        $student_details = User::fetchStudent($value->user_id);
        if (isset($student_details)) {
          $user_details[$key]['dob'] = $student_details->dob ? $student_details->dob : '-';
          $user_details[$key]['father_name'] = $student_details->father_name ? $student_details->father_name : '-';
          $user_details[$key]['mother_name'] = $student_details->mother_name ? $student_details->mother_name : '-';
          $user_details[$key]['nationality'] = $student_details->nationality ? $student_details->nationality : '-';
          $user_details[$key]['religion'] = $student_details->religion ? $student_details->religion : '-';
          $user_details[$key]['category'] = $student_details->category ? $student_details->category : '-';
          $user_details[$key]['adhaar_card'] = $student_details->adhaar_card ? $student_details->adhaar_card : '-';
          $user_details[$key]['gender'] = $student_details->gender ? $student_details->gender : '-';
          $user_details[$key]['admission_no'] = $student_details->admission_no ? $student_details->admission_no : '-';
          $user_details[$key]['roll_no'] = $student_details->roll_no ? $student_details->roll_no : '-';
          $user_details[$key]['joining_date'] = $student_details->joining_date ? $student_details->joining_date : '-';
          $user_details[$key]['guardian'] = $student_details->guardian ? $student_details->guardian : '-';
          $user_details[$key]['relation'] = $student_details->relation ? $student_details->relation : '-';
          $user_details[$key]['occupation'] = $student_details->occupation ? $student_details->occupation : '-';
          $user_details[$key]['last_school'] = $student_details->last_school ? $student_details->last_school : '-';
          $user_details[$key]['transfer_certificate'] = $student_details->transfer_certificate ? $student_details->transfer_certificate : '-';
          $user_details[$key]['migration_certificate'] = $student_details->migration_certificate ? $student_details->migration_certificate : '-';
          $user_details[$key]['birth_certificate'] = $student_details->birth_certificate ? $student_details->birth_certificate : '-';
          $user_details[$key]['marksheet_certificate'] = $student_details->marksheet_certificate ? $student_details->marksheet_certificate : '-';
          $user_details[$key]['adhaar_card_certificate'] = $student_details->adhaar_card_certificate ? $student_details->adhaar_card_certificate : '-';
        }
      }
      return apiResponse(200, lang('Students fetched successfully!'), null, $user_details);
    } else {
      return apiResponse(200, lang('No User Data FOund!'), null, []);
    }
  }
  public function getAssignedStudents($id)
  {
    $classes = ClassIncharge::where('teacher_id', $id)->get();
    $class_array = [];
    $student_ids = [];
    if (isset($classes) && count($classes) > 0) {
      foreach ($classes as $key => $class_id) {
        $class_array[] = $class_id->class_id;
      }
    }
    if (isset($class_array) && count($class_array) > 0) {
      foreach ($class_array as $key2 => $arr) {
        $stus = [];
        $stus = StudentSchoolStatus::where('class_id', $arr)->get();
        if (isset($stus) && count($stus) > 0) {
          foreach ($stus as $key3 => $arr3) {
            $student_ids[] = $arr3->student_id;
          }
        }
      }
    }
    $user_details = User::getAssignedStudents($student_ids);
    if (isset($user_details) && count($user_details) > 0) {
      foreach ($user_details as $key => $value) {
        $user_details[$key]['profile_picture'] = $value->profile_picture ? url($value->profile_picture) : null;
        $user_details[$key]['class_id'] = DB::table('student_school_statuses')->where('student_id', $user_details[$key]->user_id)->where('status', 'active')->value('class_id');
        $user_details[$key]['class_name'] = ClassDetail::where('id', $user_details[$key]->class_id)->value('class_name');
        $student_details = User::fetchStudent($value->user_id);
        if (isset($student_details)) {
          $user_details[$key]['dob'] = $student_details->dob ? $student_details->dob : '-';
          $user_details[$key]['father_name'] = $student_details->father_name ? $student_details->father_name : '-';
          $user_details[$key]['mother_name'] = $student_details->mother_name ? $student_details->mother_name : '-';
          $user_details[$key]['nationality'] = $student_details->nationality ? $student_details->nationality : '-';
          $user_details[$key]['religion'] = $student_details->religion ? $student_details->religion : '-';
          $user_details[$key]['category'] = $student_details->category ? $student_details->category : '-';
          $user_details[$key]['adhaar_card'] = $student_details->adhaar_card ? $student_details->adhaar_card : '-';
          $user_details[$key]['gender'] = $student_details->gender ? $student_details->gender : '-';
          $user_details[$key]['admission_no'] = $student_details->admission_no ? $student_details->admission_no : '-';
          $user_details[$key]['roll_no'] = $student_details->roll_no ? $student_details->roll_no : '-';
          $user_details[$key]['joining_date'] = $student_details->joining_date ? $student_details->joining_date : '-';
          $user_details[$key]['guardian'] = $student_details->guardian ? $student_details->guardian : '-';
          $user_details[$key]['relation'] = $student_details->relation ? $student_details->relation : '-';
          $user_details[$key]['occupation'] = $student_details->occupation ? $student_details->occupation : '-';
          $user_details[$key]['last_school'] = $student_details->last_school ? $student_details->last_school : '-';
          $user_details[$key]['transfer_certificate'] = $student_details->transfer_certificate ? $student_details->transfer_certificate : '-';
          $user_details[$key]['migration_certificate'] = $student_details->migration_certificate ? $student_details->migration_certificate : '-';
          $user_details[$key]['birth_certificate'] = $student_details->birth_certificate ? $student_details->birth_certificate : '-';
          $user_details[$key]['marksheet_certificate'] = $student_details->marksheet_certificate ? $student_details->marksheet_certificate : '-';
          $user_details[$key]['adhaar_card_certificate'] = $student_details->adhaar_card_certificate ? $student_details->adhaar_card_certificate : '-';
        }
      }
      return apiResponse(200, lang('Students fetched successfully!'), null, $user_details);
    } else {
      return apiResponse(200, lang('No User Data FOund!'), null, []);
    }
  }

  public function getAccountants()
  {
    $user_details = User::fetchAccountants();
    if (isset($user_details) && count($user_details) > 0) {
      foreach ($user_details as $key => $value) {
        $user_details[$key]['profile_picture'] = $value->profile_picture ? url($value->profile_picture) : null;
      }
      return apiResponse(200, lang('Accountants fetched successfully!'), null, $user_details);
    } else {
      return apiResponse(200, lang('No User Data FOund!'), null, []);
    }
  }

  public function updateprofile(Request $request, $id)
  {
    if (isset($request->name)) {
      $inputs['name'] = $request->name;
    }
    if (isset($request->email)) {
      $inputs['email'] = $request->email;
    }
    if (isset($request->address)) {
      $inputs['address'] = $request->address;
    }
    if (isset($request->is_blocked)) {
      $inputs['is_blocked'] = ($request->is_blocked == 'blocked') ? config('achiever.auth.blocked') : config('achiever.auth.unblocked');
    }
    if (isset($request->status)) {
      $inputs['status'] = ($request->status == 'inactive') ? config('achiever.auth.inactive') : config('achiever.auth.active');
    }
    if ($request->hasFile('myFile')) {
      $file = $request->file('myFile');
      $filename = $file->getClientOriginalName();
      $fileExtension = $file->getClientOriginalExtension();
      $name = 'profile_image_' . uniqid() . '.' . $file->getClientOriginalExtension();
      $request->myFile->move(public_path() . '/storage/profile', $name);
      $path = 'storage/profile/' . $name;
      $inputs['profile_picture'] = $path;
    } else {
      $inputs['profile_picture'] = null;
    }
    User::where('id', $id)->update($inputs);
    $user_details = User::fetchUser($id);
    if (isset($user_details)) {
      $user_details->profile_picture = $user_details->profile_picture ? url($user_details->profile_picture) : null;
      return apiResponse(200, lang('User Information Updated Successfully!'), null, $user_details);
    } else {
      return apiResponse(200, lang('No User Data FOund!'), null, null);
    }
  }
  public function appUpdateprofile(Request $request)
  {
    if (isset($request->name)) {
      $inputs['name'] = $request->name;
    }
    if (isset($request->email)) {
      $inputs['email'] = $request->email;
    }
    if (isset($request->address)) {
      $inputs['address'] = $request->address;
    }
    if (isset($request->is_blocked)) {
      $inputs['is_blocked'] = ($request->is_blocked == 'blocked') ? config('achiever.auth.blocked') : config('achiever.auth.unblocked');
    }
    if (isset($request->status)) {
      $inputs['status'] = ($request->status == 'inactive') ? config('achiever.auth.inactive') : config('achiever.auth.active');
    }
    if ($request->hasFile('myFile')) {
      $file = $request->file('myFile');
      $filename = $file->getClientOriginalName();
      $fileExtension = $file->getClientOriginalExtension();
      $name = 'profile_image_' . uniqid() . '.' . $file->getClientOriginalExtension();
      $request->myFile->move(public_path() . '/storage/profile', $name);
      $path = 'storage/profile/' . $name;
      $inputs['profile_picture'] = $path;
    } else {
      $inputs['profile_picture'] = null;
    }
    User::where('id', $request->id)->update($inputs);
    return apiResponse(200, lang('User Information Updated Successfully!'), null, null);
  }
  public function deleteUser($id)
  {
    $user_Details = User::where('id', $id)->first();
    if (isset($user_Details) && $user_Details->user_type == "student") {
      StudentDetail::where('user_id', $id)->delete();
    }
    User::where('id', $id)->delete();
    return apiResponse(200, lang('User deleted successfully!'), null, null);
  }

  public function createSubadmin(Request $request)
  {
    $inputs = $request->all();
    $data["email"] = strtolower($inputs["email"]);
    $data["name"] = $inputs["name"];
    $data["password"] = Hash::make($inputs["password"]);
    $data["phone_number"] = $inputs["phone_number"];
    $validator = User::validateSubAdmin($inputs);
    if ($validator->fails()) {
      $messages = implode(",", errorMessages($validator->messages()));
      return apiResponse(200, $messages, null, null);
    }
    $data["status"] = 1;
    $data["is_blocked"] = 1;
    $data["user_type"] = 2;
    $user_details = User::create($data);
    return apiResponse(200, lang('Sub Admin Created successfully!'), null, $user_details);
  }

  public function createAccountant(Request $request)
  {
    $inputs = $request->all();
    $data["email"] = strtolower($inputs["email"]);
    $data["name"] = $inputs["name"];
    $data["password"] = Hash::make($inputs["password"]);
    $data["phone_number"] = $inputs["phone_number"];
    $validator = User::validateSubAdmin($inputs);
    if ($validator->fails()) {
      $messages = implode(",", errorMessages($validator->messages()));
      return apiResponse(200, $messages, null, null);
    }
    $data["status"] = 1;
    $data["is_blocked"] = 1;
    $data["user_type"] = 3;
    $user_details = User::create($data);
    return apiResponse(200, lang('Accountant Created successfully!'), null, $user_details);
  }

  public function createTeacher(Request $request)
  {
    $inputs = $request->all();
    $data["email"] = strtolower($inputs["email"]);
    $data["name"] = $inputs["name"];
    $data["password"] = Hash::make($inputs["password"]);
    $data["phone_number"] = $inputs["phone_number"];
    $validator = User::validateSubAdmin($inputs);
    if ($validator->fails()) {
      $messages = implode(",", errorMessages($validator->messages()));
      return apiResponse(200, $messages, null, null);
    }
    $data["status"] = 1;
    $data["is_blocked"] = 1;
    $data["user_type"] = 4;
    $user_details = User::create($data);
    return apiResponse(200, lang('Teacher Created successfully!'), null, $user_details);
  }

  public function createStudent(Request $request)
  {
    $inputs = $request->all();
    $data["email"] = strtolower($inputs["email"]);
    $data["name"] = $inputs["name"];
    $data["address"] = $inputs["address"];
    $data["password"] = Hash::make($inputs["password"]);
    $data["phone_number"] = $inputs["phone_number"];
    $validator = User::validateSubAdmin($inputs);
    if ($validator->fails()) {
      $messages = implode(",", errorMessages($validator->messages()));
      return apiResponse(200, $messages, null, null);
    }
    $data["status"] = 1;
    $data["is_blocked"] = 1;
    $data["user_type"] = 5;
    $user_details = User::create($data);
    if (isset($user_details)) {
      $details_input['user_id'] = $user_details->id;
      $details_input['dob'] = date('Y-m-d H:i:s', strtotime($inputs["dob"]));
      $details_input['father_name'] = $inputs["father_name"];
      $details_input['mother_name'] = $inputs["mother_name"];
      $details_input['father_id'] = $inputs["father_id"];
      $details_input['mother_id'] = $inputs["mother_id"];
      $details_input['staff_child'] = $inputs["staff_child"];
      $details_input['adhaar_card'] = $inputs["adhaar_card"];
      $details_input['adhaar_card_certificate'] = $inputs["adhaar_card_certificate"];
      $details_input['admission_no'] = $inputs["admission_no"];
      $details_input['birth_certificate'] = $inputs["birth_certificate"];
      $details_input['category'] = $inputs["category"];
      $details_input['gender'] = $inputs["gender"];
      $details_input['guardian'] = $inputs["guardian"];
      $details_input['occupation'] = $inputs["occupation"];
      $details_input['joining_date'] = $inputs["joining_date"];
      $details_input['last_school'] = $inputs["last_school"];
      $details_input['marksheet_certificate'] = $inputs["marksheet_certificate"];
      $details_input['migration_certificate'] = $inputs["migration_certificate"];
      $details_input['nationality'] = $inputs["nationality"];
      $details_input['relation'] = $inputs["relation"];
      $details_input['religion'] = $inputs["religion"];
      $details_input['roll_no'] = $inputs["roll_no"];
      $details_input['transfer_certificate'] = $inputs["transfer_certificate"];
      $student_details = StudentDetail::create($details_input);
      if (isset($student_details)) {
        $school_status['student_id'] = $user_details->id;
        $school_status['class_id'] = $inputs["student_class"];
        $school_status['session_id'] = getActiveSession();
        $school_status['status'] = 1;
        $status_details = StudentSchoolStatus::create($school_status);
        if (isset($status_details)) {
          return apiResponse(200, lang('Student Created successfully!'), null, $status_details);
        } else {
          return apiResponse(200, lang('Something Went Wrong!'), null, null);
        }
      }
    } else {
      return apiResponse(400, lang('Something Went Wrong!'), null, null);
    }
  }

  public function updateStudent(Request $request, $id)
  {
    if (isset($request->name) && $request->name != '') {
      $user_inputs['name'] = $request->name;
    }
    if (isset($request->phone_number) && $request->phone_number != '') {
      $user_inputs['phone_number'] = $request->phone_number;
    }
    if (isset($request->address) && $request->address != '') {
      $user_inputs['address'] = $request->address;
    }
    if (isset($request->phone_number) && $request->phone_number != '') {
      $get_user = User::where('phone_number', $request->phone_number)->first();
      if (isset($get_user)) {
        if ($get_user->id == $id) {
          $user_inputs['phone_number'] = $request->phone_number;
        } else {
          return apiResponse(400, lang('Mobile Number is Already in use!'), null, null);
        }
      }
    }
    if (isset($request->status) && $request->status != '') {
      $user_inputs['status'] = ($request->status == 'active') ? 1 : 2;
    }

    if (isset($request->is_blocked) && $request->is_blocked != '') {
      $user_inputs['is_blocked'] = ($request->is_blocked == 'unblocked') ? 1 : 2;
    }
    $user_details = User::where('id', $id)->update($user_inputs);
    if (isset($request->dob) && $request->dob != '') {
      $student_details['dob'] = date('Y-m-d H:i:s', strtotime($request->dob));
    }
    if (isset($request->father_name) && $request->father_name != '') {
      $student_details['father_name'] = $request->father_name;
    }
    if (isset($request->mother_name) && $request->mother_name != '') {
      $student_details['mother_name'] = $request->mother_name;
    }
    if (isset($request->father_id) && $request->father_id != '') {
      $student_details['father_id'] = $request->father_id;
    }
    if (isset($request->mother_id) && $request->mother_id != '') {
      $student_details['mother_id'] = $request->mother_id;
    }
    if (isset($request->staff_child) && $request->staff_child != '') {
      $student_details['staff_child'] = $request->staff_child;
    }

    if (isset($request->adhaar_card) && $request->adhaar_card != '') {
      $student_details['adhaar_card'] = $request->adhaar_card;
    }

    if (isset($request->adhaar_card_certificate) && $request->adhaar_card_certificate != '') {
      $student_details['adhaar_card_certificate'] = $request->adhaar_card_certificate;
    }
    if (isset($request->admission_no) && $request->admission_no != '') {
      $student_details['admission_no'] = $request->admission_no;
    }
    if (isset($request->birth_certificate) && $request->birth_certificate != '') {
      $student_details['birth_certificate'] = $request->birth_certificate;
    }

    if (isset($request->category) && $request->category != '') {
      $student_details['category'] = $request->category;
    }
    if (isset($request->gender) && $request->gender != '') {
      $student_details['gender'] = $request->gender;
    }
    if (isset($request->guardian) && $request->guardian != '') {
      $student_details['guardian'] = $request->guardian;
    }
    if (isset($request->joining_date) && $request->joining_date != '') {
      $student_details['joining_date'] = $request->joining_date;
    }
    if (isset($request->last_school) && $request->last_school != '') {
      $student_details['last_school'] = $request->last_school;
    }

    if (isset($request->marksheet_certificate) && $request->marksheet_certificate != '') {
      $student_details['marksheet_certificate'] = $request->marksheet_certificate;
    }
    if (isset($request->migration_certificate) && $request->migration_certificate != '') {
      $student_details['migration_certificate'] = $request->migration_certificate;
    }
    if (isset($request->nationality) && $request->nationality != '') {
      $student_details['nationality'] = $request->nationality;
    }

    if (isset($request->occupation) && $request->occupation != '') {
      $student_details['occupation'] = $request->occupation;
    }
    if (isset($request->relation) && $request->relation != '') {
      $student_details['relation'] = $request->relation;
    }
    if (isset($request->religion) && $request->religion != '') {
      $student_details['religion'] = $request->religion;
    }
    if (isset($request->roll_no) && $request->roll_no != '') {
      $student_details['roll_no'] = $request->roll_no;
    }
    if (isset($request->transfer_certificate) && $request->transfer_certificate != '') {
      $student_details['transfer_certificate'] = $request->transfer_certificate;
    }








    $update_details = StudentDetail::where('user_id', $id)->update($student_details);
    $status_details = StudentSchoolStatus::where('student_id', $id)->where('status', 1)->first();
    if (isset($status_details)) {
      if (date('Y', $status_details->from) != date('Y', strtotime($request->from))) {
        StudentSchoolStatus::where('id', $status_details->id)->where('status', 1)->update(['status' => 2, 'to' => Carbon::now()->timestamp]);
        $new_det['student_id'] = $id;
        $new_det['class_id'] = $request->student_class;
        $new_det['from'] = strtotime($request->from);
        $new_det['status'] = 1;
        StudentSchoolStatus::create($new_det);
      } else {
        if (isset($request->student_class) && $request->student_class != '') {
          $update_det['class_id'] = $request->student_class;
        }
        StudentSchoolStatus::where('id', $status_details->id)->where('status', 1)->update($update_det);
      }
    }
    return apiResponse(200, lang('User Updated successfully!'), null, $user_details);
  }

  public function getMonths()
  {
    $months = DB::table('months')->get();
    return apiResponse(200, lang('Months Fetched successfully!'), null, $months);
  }

  public function studentInfo($id)
  {
    $student_details = User::fetchStudent($id);
    unset($student_details->password);
    $whole_details = [];
    if (isset($student_details)) {
      $status_details = StudentSchoolStatus::where('student_id', $id)->get();
      if (isset($status_details) && count($status_details) > 0) {
        $current_class_details = DB::table('student_school_statuses')->select('class_details.id as current_class', 'class_details.class_name as current_class_name')->leftJoin('class_details', 'class_details.id', 'student_school_statuses.class_id')->where('student_school_statuses.status', 1)->where('student_id', $id)->first();
        // dd($current_class_details);
        if (isset($current_class_details)) {
          $student_details->current_class_id = $current_class_details->current_class;
          $student_details->current_class_name = $current_class_details->current_class_name;
          $student_details->from = date('Y-m-d');
        } else {
          $student_details->current_class_id = null;
          $student_details->current_class_name = null;
          $student_details->from = date('Y-m-d');
        }
        foreach ($status_details as $key => $value) {
          $fee_details = [];
          $details = $value;
          $fee_details = FeeDetail::where('student_status_id', $value->id)->get();
          if (isset($fee_details) && count($fee_details) > 0) {
            $details->fee_details = $fee_details;
          } else {
            $details->fee_details = [];
          }
          $whole_details[] = $details;
        }
      }
    }
    $data['student_details'] = $student_details;
    if (isset($student_details->current_class_id)) {
      $timetable = TimeTable::getStudentTimeTable($student_details->current_class_id);
    } else {
      $timetable = [];
    }
    $data['timetable'] = $timetable;
    $data['attendance'] = [];
    $data['fee_details'] = [];
    return apiResponse(200, lang('Student Details Fetched successfully!'), null, $data);
  }

  public function fetchStudent($id)
  {
    $student_details = User::fetchStudent($id);
    $student_details->joining_date = date('d F Y', strtotime($student_details->joining_date));
    $student_details->dob = date('d F Y', strtotime($student_details->dob));
    $student_details->profile_picture = ($student_details->profile_picture) ? url($student_details->profile_picture) : null;
    unset($student_details->password);
    $parent_id['label'] = null;
    $parent_id['value'] = null;
    $staff_child['label'] = 'No';
    $staff_child['value'] = 'no';
    $parent_type['label'] = null;
    $parent_type['value'] = null;
    $gender['label'] = null;
    $gender['value'] = null;
    $transfer_certificate['label'] = 'No';
    $transfer_certificate['value'] = 'no';
    $migration_certificate['label'] = 'No';
    $migration_certificate['value'] = 'no';
    $birth_certificate['label'] = 'No';
    $birth_certificate['value'] = 'no';
    $marksheet_certificate['label'] = 'No';
    $marksheet_certificate['value'] = 'no';
    $adhaar_card_certificate['label'] = 'No';
    $adhaar_card_certificate['value'] = 'no';
    if ($student_details && ($student_details->gender)) {
      $gender['label'] = ($student_details->gender == "female") ? "Female" : (($student_details->gender == "male") ? "Male" : "Other");
      $gender['value'] = $student_details->gender;
      $student_details->gender = $gender;
    }

    if ($student_details && ($student_details->transfer_certificate)) {
      $transfer_certificate['label'] = ($student_details->transfer_certificate == "yes") ? "Yes" : "No";
      $transfer_certificate['value'] = $student_details->transfer_certificate;
      $student_details->transfer_certificate = $transfer_certificate;
    }
    if ($student_details && ($student_details->migration_certificate)) {
      $migration_certificate['label'] = ($student_details->migration_certificate == "yes") ? "Yes" : "No";
      $migration_certificate['value'] = $student_details->migration_certificate;
      $student_details->migration_certificate = $migration_certificate;
    }
    if ($student_details && ($student_details->birth_certificate)) {
      $birth_certificate['label'] = ($student_details->birth_certificate == "yes") ? "Yes" : "No";
      $birth_certificate['value'] = $student_details->birth_certificate;
      $student_details->birth_certificate = $birth_certificate;
    }
    if ($student_details && ($student_details->marksheet_certificate)) {
      $marksheet_certificate['label'] = ($student_details->marksheet_certificate == "yes") ? "Yes" : "No";
      $marksheet_certificate['value'] = $student_details->marksheet_certificate;
      $student_details->marksheet_certificate = $marksheet_certificate;
    }
    if ($student_details && ($student_details->adhaar_card_certificate)) {
      $adhaar_card_certificate['label'] = ($student_details->adhaar_card_certificate == "yes") ? "Yes" : "No";
      $adhaar_card_certificate['value'] = $student_details->adhaar_card_certificate;
      $student_details->adhaar_card_certificate = $adhaar_card_certificate;
    }
    if ($student_details && ($student_details->mother_id || $student_details->father_id)) {
      $staff_child['label'] = 'Yes';
      $staff_child['value'] = 'yes';
      if (isset($student_details->mother_id)) {
        $parent_type['label'] = 'Mother';
        $parent_type['value'] = 'mother_id';
      } else {
        $parent_type['label'] = 'Father';
        $parent_type['value'] = 'father_id';
      }
      $parent_id['value'] = ($student_details->mother_id) ? $student_details->mother_id : $student_details->father_id;
      $parent_id['label'] = User::where('id', $parent_id['value'])->value('name');
    }
    $student_details->parent_id = $parent_id ? $parent_id : null;
    $student_details->staff_child = $staff_child ? $staff_child : null;
    $student_details->parent_type = $parent_type ? $parent_type : null;
    $student_details->category = ($student_details->category == "General") ? 1 : ($student_details->category == "OBC" ? 2 : ($student_details->category == "SC" ? 3 : 4));
    $whole_details = [];
    if (isset($student_details)) {
      $status_details = StudentSchoolStatus::where('student_id', $id)->get();
      if (isset($status_details) && count($status_details) > 0) {
        $current_class_details = DB::table('student_school_statuses')->select('class_details.id as current_class', 'class_details.class_name as current_class_name')->leftJoin('class_details', 'class_details.id', 'student_school_statuses.class_id')->where('student_school_statuses.status', 1)->where('student_id', $id)->first();
        // dd($current_class_details);
        if (isset($current_class_details)) {
          $student_details->current_class_id = $current_class_details->current_class;
          $student_details->current_class_name = $current_class_details->current_class_name;
          $student_details->from = date('Y-m-d');
        } else {
          $student_details->current_class_id = null;
          $student_details->current_class_name = null;
          $student_details->from = date('Y-m-d');
        }
      }
    }
    $class_id = DB::table('student_school_statuses')->where('student_id', $id)->where('status', 'active')->value('class_id');
    $attendances = Attendance::where('student_id', $id)->where('class_id', $class_id)->get();
    $data['attendanceData'] = [];
    $data['all'] = 0;
    $data['present'] = 0;
    $data['absent'] = 0;
    $data['leave'] = 0;
    $data['all'] = Attendance::where('student_id', $id)->where('class_id', $class_id)->count();
    $data['present'] = Attendance::where('student_id', $id)->where('class_id', $class_id)->where('status', 'present')->count();
    $data['absent'] = Attendance::where('student_id', $id)->where('class_id', $class_id)->where('status', 'absent')->count();
    $data['leave'] = Attendance::where('student_id', $id)->where('class_id', $class_id)->where('status', 'leave')->count();
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
    $student_details->attendance = $data;

    // TIMETABLE FETCH
    $class_id = DB::table('student_school_statuses')->where('student_id', $id)->where('status', 'active')->value('class_id');
    $hours = DB::table('hours')->get();
    $days = DB::table('days')->get();
    $new_timetable = [];

    if (isset($days) && count($days) > 0) {
      foreach ($days as $day_key => $day_value) {
        $obj['day'] = $day_value->day;
        $obj['timeTableList'] = [];
        if (isset($hours) && count($hours) > 0) {
          $ob = [];
          foreach ($hours as $key => $value) {
            $timetable = TimeTable::where('day_id', $day_value->id)->where('hour_id', $value->id)->where('class_id', $class_id)->first();
            if ($timetable) {
              array_push($ob, [
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
            }
          }
        }
        if (isset($ob) && count($ob) > 0) {
          $obj['timeTableList'] = $ob;
        }
        $new_timetable[] = $obj;
      }
    }
    $student_details->timetable = $new_timetable;
    return apiResponse(200, lang('Student Details Fetched successfully!'), null, $student_details);
  }

  public function fetchTeacher($id)
  {
    $teacher_details = User::fetchUser($id);
    $teacher_details->profile_picture = $teacher_details->profile_picture ? url($teacher_details->profile_picture) : null;
    unset($teacher_details->password);
    $name = [];
    $class_in = ClassIncharge::where('teacher_id', $id)->where('status', 'active')->get();
    if (isset($class_in) && count($class_in) > 0) {
      foreach ($class_in as $class_single) {
        $cls = ClassDetail::where('id', $class_single->class_id)->value('class_name');
        if (isset($cls)) {
          $name[] = $cls;
        }
      }
    }
    if (isset($name)) {
      $teacher_details->class_incharge = implode(',', $name);
    } else {
      $teacher_details->class_incharge = null;
    }
    // TIMETABLE FETCH
    $hours = DB::table('hours')->get();
    $days = DB::table('days')->get();
    $new_timetable = [];

    if (isset($days) && count($days) > 0) {
      foreach ($days as $day_key => $day_value) {
        $obj['day'] = $day_value->day;
        $obj['timeTableList'] = [];
        if (isset($hours) && count($hours) > 0) {
          $ob = [];
          foreach ($hours as $key => $value) {
            $timetable = TimeTable::where('day_id', $day_value->id)->where('hour_id', $value->id)->where('teacher_id', $id)->first();
            if ($timetable) {
              array_push($ob, [
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
            }
          }
        }
        if (isset($ob) && count($ob) > 0) {
          $obj['timeTableList'] = $ob;
        }
        $new_timetable[] = $obj;
      }
    }
    $teacher_details->timetable = $new_timetable;
    return apiResponse(200, lang('Student Details Fetched successfully!'), null, $teacher_details);
  }
}
