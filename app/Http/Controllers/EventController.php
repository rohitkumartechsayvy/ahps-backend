<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function createEvent(Request $request)
  {
    $inputs = $request->all();
    $validator = Event::validateEvent($inputs);
    if ($validator->fails()) {
      $messages = implode(",", errorMessages($validator->messages()));
      return apiResponse(200, null, [$messages], null);
    }
    if (isset($inputs['gallery']) && count($inputs['gallery']) > 0) {
      $inputs['gallery'] = implode(',', $inputs['gallery']);
    } else {
      $inputs['gallery'] = null;
    }
    $event_details = Event::create($inputs);
    return apiResponse(200, lang('Event Created Successfully!'), null, $event_details);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function upload(Request $request)
  {
    if ($request->hasFile('file')) {
      $file = $request->file('file');
      $filename = $file->getClientOriginalName();
      $fileExtension = $file->getClientOriginalExtension();
      $name = 'gallery_image_' . uniqid() . '.' . $file->getClientOriginalExtension();
      $request->file->move(public_path() . '/storage/gallery', $name);
      $path = 'storage/gallery/' . $name;
      $inputs['gallery_picture'] = $path;
    } else {
      $inputs['gallery_picture'] = null;
    }
    return apiResponse(200, lang('Image Uploaded Successfully!'), null, $inputs['gallery_picture']);
  }
  public function assignment(Request $request)
  {
    $assignments = [];
    if ($request->hasFile('file')) {
      foreach ($request->file('file') as $file) {
        $filename = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();
        $name = 'assignment_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path() . '/storage/assignments', $name);
        $assignments[] = 'storage/assignments/' . $name;
      }
    }
    return apiResponse(200, lang('Assignments Uploaded Successfully!'), null, $assignments);
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Event  $event
   * @return \Illuminate\Http\Response
   */
  public function getEvents()
  {
    $events = Event::fetchEvents();
    if (isset($events) && count($events) > 0) {
      foreach ($events as $key => $event) {
        if (isset($event->gallery) && $event->gallery != "") {
          $gallery_array = explode(",", $event->gallery);
          if (isset($gallery_array) && count($gallery_array) > 0) {
            foreach ($gallery_array as $gallery_key => $gal) {
              $gallery_array[$gallery_key] = url($gal);
            }
          }
          $event->gallery = implode(',', $gallery_array);
        }
        $event->profile_picture = ($event->profile_picture) ? url($event->profile_picture) : null;
      }
    }
    return apiResponse(200, lang('Events Fetched Successfully!'), null, $events);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Event  $event
   * @return \Illuminate\Http\Response
   */
  public function fetchEvent($id)
  {
    $events = Event::fetchEvent($id);
    if (isset($events) && $events->approved_by) {
      $events->approved_by_name = User::where('id', $events->approved_by)->value('name');
    } else {
      $events->approved_by_name = null;
    }
    return apiResponse(200, lang('Events Fetched Successfully!'), null, $events);
  }

  public function approveEvent(Request $request, $id)
  {
    // dd($request->all());
    $events = Event::where('id', $id)->update(['approved_by' => $request->approved_by]);
    return apiResponse(200, lang('Event Approved Successfully!'), null, $events);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Event  $event
   * @return \Illuminate\Http\Response
   */
  public function updateEvent(Request $request, $id)
  {
    $inputs = $request->all();
    $validator = Event::validateEvent($inputs);
    $event_details = Event::where('id', $id)->update($inputs);
    return apiResponse(200, lang('Event Updated Successfully!'), null, $event_details);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Event  $event
   * @return \Illuminate\Http\Response
   */
  public function removeEvent(Request $request, $id)
  {
    $event_details = Event::where('id', $id)->delete();
    return apiResponse(200, lang('Event Deleted Successfully!'), null, null);
  }
}
