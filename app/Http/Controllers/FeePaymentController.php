<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class FeePaymentController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function initiate(Request $request)
    {
        $api = new Api(config('achiever.auth.RAZOR_KEY'), config('achiever.auth.RAZOR_SECRET'));
        dd($api);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FeePayment  $feePayment
     * @return \Illuminate\Http\Response
     */
    public function show(FeePayment $feePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeePayment  $feePayment
     * @return \Illuminate\Http\Response
     */
    public function edit(FeePayment $feePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FeePayment  $feePayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FeePayment $feePayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FeePayment  $feePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeePayment $feePayment)
    {
        //
    }
}
