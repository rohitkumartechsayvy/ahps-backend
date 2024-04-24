<?php

namespace App\Http\Controllers;

use App\Models\ClassDetail;
use App\Models\FeeVoucher;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Models\FeeLog;
use App\Models\FeeDetail;
use App\Models\FeePayment;
use App\Models\FeeVoucherLog;
use App\User;
use Razorpay\Api\Api;

class FeeVoucherController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function createFeeVoucher(Request $request)
  {
    $inputs = $request->all();
    // dd($inputs);
    if (isset($inputs['students']) && count($inputs['students']) > 0) {
      foreach ($inputs['students'] as $key => $student) {
        // dd($student);
        $class_id = DB::table('student_school_statuses')->where('student_id', $student)->where('status', 'active')->value('class_id');
        $total_fee = 0;
        if (isset($inputs['fees']) && count($inputs['fees']) > 0) {
          foreach ($inputs['fees'] as $key_new => $fee) {
            if (isset($fee['check_status']) && ($fee['check_status'] == true)) {
              $total_fee += (int) FeeLog::where('class_id', $class_id)->where('fee_id', $fee['charge_id'])->value('amount');
            }
          }
        }
        $create_voucher = [];
        $create_voucher['student_id'] = $student;
        $create_voucher['due_date']  = (date('Y-m', strtotime(Carbon::parse($inputs['fee_month'])))) . '-10';
        $create_voucher['issue_date']  = date('Y-m-d h:i:s');
        $create_voucher['total_fee']  = $total_fee;
        $create_voucher['fee_status']  = 1;
        $create_voucher['fee_month']  = $inputs['fee_month'];
        $create_voucher['session_id']  = getActiveSession();
        $voucher_details = FeeVoucher::create($create_voucher);
        if (isset($voucher_details)) {
          if (isset($inputs['fees']) && count($inputs['fees']) > 0) {
            foreach ($inputs['fees'] as $key_new => $fee) {
              if (isset($fee['check_status']) && ($fee['check_status'] == true)) {
                $log_obj = [];
                $log_obj['voucher_id'] = $voucher_details->id;
                $log_obj['charge_id'] = $fee['charge_id'];
                $fee_detail_log = FeeLog::where('class_id', $class_id)->where('fee_id', $fee['charge_id'])->first();
                if (isset($fee_detail_log)) {
                  $log_obj['charge_amount'] = $fee_detail_log->amount;
                  FeeVoucherLog::create($log_obj);
                } else {
                  FeeVoucher::where('id', $voucher_details->id)->delete();
                  return apiResponse(200, null, ['Class charges not created yet!'], null);
                }
              }
            }
          }
        }
      }
    }
    return apiResponse(200, lang("Voucher Created Successfully!"), null, null);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function fetchFeeVouchers(Request $request)
  {
    $fee_vouchers = FeeVoucher::get();
    if (isset($fee_vouchers) && count($fee_vouchers) > 0) {
      foreach ($fee_vouchers as $key => $voucher) {
        $obj = $voucher;
        $obj->student_name = User::where('id', $voucher->student_id)->value('name');
        $class_id = DB::table('student_school_statuses')->where('student_id', $voucher->student_id)->where('status', 'active')->value('class_id');
        $obj->class_name = ClassDetail::where('id', $class_id)->value('class_name');
        $obj->class_id = $class_id;
        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
        $voucher_detail = FeeVoucher::where('id', $voucher->id)->first();
        $voucher_detail->student_details = User::fetchStudent($voucher_detail->student_id);
        if (isset($voucher_detail->student_details) && isset(($voucher_detail->student_details)->password)) {
          unset(($voucher_detail->student_details)->password);
        }
        // $class_id = DB::table('student_school_statuses')->where('student_id', $voucher_detail->student_id)->where('status', 'active')->value('class_id');
        $voucher_detail->class_name = ClassDetail::where('id', $class_id)->value('class_name');
        $surcharge_id = FeeDetail::where('title', 'Late Fee')->value('id');
        $voucher_detail->in_words = $f->format($voucher_detail->total_fee);
        $voucher_detail->late_fee = (int) FeeLog::where('class_id', $class_id)->where('fee_id', $surcharge_id)->value('amount');
        $voucher_detail->fee_after_due_date = $voucher_detail->total_fee + ((int) FeeLog::where('class_id', $class_id)->where('fee_id', $surcharge_id)->value('amount'));
        $logs = FeeVoucherLog::where('voucher_id', $voucher_detail->id)->get();
        $particulars = [];
        if (isset($logs) && count($logs) > 0) {
          foreach ($logs as $key => $log) {
            $log_obj = [];
            $log_obj['particulars'] = FeeDetail::where('id', $log->charge_id)->value('title');
            $log_obj['amount'] = $log->charge_amount;
            $particulars[] = $log_obj;
          }
        }
        $voucher_detail->particulars = $particulars;
        $obj->voucher_detail = $voucher_detail;
      }
    }
    return apiResponse(200, lang("Fee Vouchers Fetched Successfully!"), null, $fee_vouchers);
    // dd($fee_vouchers);
  }

  public function fetchStudentFeeVouchers($student_id)
  {
    $fee_vouchers = FeeVoucher::where('student_id', $student_id)->get();
    if (isset($fee_vouchers) && count($fee_vouchers) > 0) {
      foreach ($fee_vouchers as $key => $voucher) {
        $obj = $voucher;
        $obj->student_name = User::where('id', $voucher->student_id)->value('name');
        $class_id = DB::table('student_school_statuses')->where('student_id', $voucher->student_id)->where('status', 'active')->value('class_id');
        $obj->class_name = ClassDetail::where('id', $class_id)->value('class_name');
        $obj->class_id = $class_id;
        $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
        $voucher_detail = FeeVoucher::where('id', $voucher->id)->first();
        $voucher_detail->student_details = User::fetchStudent($voucher_detail->student_id);
        $payment_record = FeePayment::where('voucher_id', $obj->id)->first();
        if (isset($payment_record)) {
          $voucher_detail->payment_mode = $payment_record->payment_mode;
        } else {
          $voucher_detail->payment_mode = null;
        }
        // $class_id = DB::table('student_school_statuses')->where('student_id', $voucher_detail->student_id)->where('status', 'active')->value('class_id');
        $voucher_detail->class_name = ClassDetail::where('id', $class_id)->value('class_name');
        $surcharge_id = FeeDetail::where('title', 'Late Fee')->value('id');
        $voucher_detail->in_words = $f->format($voucher_detail->total_fee);
        $voucher_detail->late_fee = (int) FeeLog::where('class_id', $class_id)->where('fee_id', $surcharge_id)->value('amount');
        $voucher_detail->fee_after_due_date = $voucher_detail->total_fee + ((int) FeeLog::where('class_id', $class_id)->where('fee_id', $surcharge_id)->value('amount'));
        $logs = FeeVoucherLog::where('voucher_id', $voucher_detail->id)->get();
        $particulars = [];
        if (isset($logs) && count($logs) > 0) {
          foreach ($logs as $key => $log) {
            $log_obj = [];
            $log_obj['particulars'] = FeeDetail::where('id', $log->charge_id)->value('title');
            $log_obj['amount'] = $log->charge_amount;
            $particulars[] = $log_obj;
          }
        }
        $voucher_detail->particulars = $particulars;
        $obj->voucher_detail = $voucher_detail;
      }
    }
    return apiResponse(200, lang("Fee Vouchers Fetched Successfully!"), null, $fee_vouchers);
    // dd($fee_vouchers);
  }
  public function getVoucherDetail($id)
  {
    $f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
    $voucher_detail = FeeVoucher::where('id', $id)->first();
    $voucher_detail->student_details = User::fetchStudent($voucher_detail->student_id);
    unset(($voucher_detail->student_details)->password);
    $class_id = DB::table('student_school_statuses')->where('student_id', $voucher_detail->student_id)->where('status', 'active')->value('class_id');
    $voucher_detail->class_name = ClassDetail::where('id', $class_id)->value('class_name');
    $surcharge_id = FeeDetail::where('title', 'Late Fee')->value('id');
    $voucher_detail->in_words = $f->format($voucher_detail->total_fee);
    $voucher_detail->late_fee = (int) FeeLog::where('class_id', $class_id)->where('fee_id', $surcharge_id)->value('amount');
    $voucher_detail->fee_after_due_date = $voucher_detail->total_fee + ((int) FeeLog::where('class_id', $class_id)->where('fee_id', $surcharge_id)->value('amount'));
    $logs = FeeVoucherLog::where('voucher_id', $voucher_detail->id)->get();
    $particulars = [];
    if (isset($logs) && count($logs) > 0) {
      foreach ($logs as $key => $log) {
        $log_obj = [];
        $log_obj['particulars'] = FeeDetail::where('id', $log->charge_id)->value('title');
        $log_obj['amount'] = $log->charge_amount;
        $particulars[] = $log_obj;
      }
    }
    $voucher_detail->particulars = $particulars;
    return apiResponse(200, lang("Voucher Detaila Fetched Successfully!"), null, $voucher_detail);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\FeeVoucher  $feeVoucher
   * @return \Illuminate\Http\Response
   */
  public function payment(Request $request)
  {
    $input = $request->all();
    $api = new Api('rzp_live_sqUn77hYRrDzwX', 'bMm0mC3JQZbLpoSDeghvVsZK');
    $payment = $api->payment->fetch('7894545');
    if (count($input)  && !empty('7894545')) {
      try {
        $response = $api->payment->fetch('7894545')->capture(array('amount' => 100));
      } catch (\Exception $e) {
        return  $e->getMessage();
        \Session::put('error', $e->getMessage());
        return redirect()->back();
      }
    }
    \Session::put('success', 'Payment successful');
    return redirect()->back();
  }
  public function savePayment(Request $request)
  {
    $api = new Api('rzp_live_sqUn77hYRrDzwX', 'bMm0mC3JQZbLpoSDeghvVsZK');
    $payment_details = $api->payment->fetch($request->payment_id);
    $payment_obj['voucher_id'] = $request->voucher_id;
    $payment_obj['transaction_id'] = $payment_details['id'];
    $payment_obj['transaction_details'] = serialize(($payment_details->toArray()));
    $payment_obj['paid_amount'] = (string) ($payment_details['amount'] / 100);
    $payment_obj['payment_mode'] = $payment_details['card_id'] ? 'card Payment' : ($payment_details['bank'] ? 'Net Banking' : ($payment_details['wallet'] ? $payment_details['wallet'] : ($payment_details['vpa'] ? 'UPI' : 'Unknown')));
    $saved_payment = FeePayment::create($payment_obj);
    if (isset($saved_payment)) {
      FeeVoucher::where('id', $request->voucher_id)->update(['fee_status' => 2]);
      return apiResponse(200, lang("Payment Done Successfully!"), null, null);
    } else {
      return apiResponse(200, lang("Something Went Wrong While Processing Payment!"), null, null);
    }
  }
  public function cashPayment(Request $request)
  {
    $amount = FeeVoucher::where('id', $request->voucher_id)->value('total_fee');
    $account_details = User::where('id', $request->accountant_id)->first();
    $payment_obj['voucher_id'] = $request->voucher_id;
    $payment_obj['transaction_id'] = "Paid Cash";
    $payment_obj['transaction_details'] = "Marked Paid By Accountant ID: " . $account_details->id . ' (' . $account_details->name . ')';
    $payment_obj['paid_amount'] = (string) $amount;
    $payment_obj['payment_mode'] = 'cash';
    $saved_payment = FeePayment::create($payment_obj);
    if (isset($saved_payment)) {
      FeeVoucher::where('id', $request->voucher_id)->update(['fee_status' => 2]);
      return apiResponse(200, lang("Payment Done Successfully!"), null, null);
    } else {
      return apiResponse(200, lang("Something Went Wrong While Processing Payment!"), null, null);
    }
  }
}
