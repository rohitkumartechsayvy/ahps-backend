<?php

use App\User;
use App\Models\Session;

function truncate($str, $length)
{
  if (strlen($str) > $length) {
    $str = substr($str, 0, $length + 1);
    $pos = strrpos($str, ' ');
    $str = substr($str, 0, ($pos > 0) ? $pos : $length);
    $str = $str . '...';
  }
  return $str;
}

function YoutubeID($url)
{
  if (strlen($url) > 11) {
    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
      return $match[1];
    } else
      return false;
  }
  return $url;
}
function getActiveSession()
{
  return Session::where('session_status', 'active')->value('id');
}
function apiResponse($statusCode, $message, $errors = [], $result = null)
{
  // dd($result);
  $response = ['statusCode' => $statusCode];

  if ($message != "") {
    $response['message'] = $message;
  }

  if (isset($errors)) {
    if (count($errors) > 0) {
      $response['message']['errors'] = $errors;
    }
  }

  if (isset($result)) {
    $response['response'] = $result;
  }
  return response()->json($response, $statusCode);
}
function lang($path = null, $string = null)
{
  $lang = $path;
  if (trim($path) != '' && trim($string) == '') {
    $lang = \Lang::get($path);
  } elseif (trim($path) != '' && trim($string) != '') {
    $lang = \Lang::get($path, ['attribute' => $string]);
  }
  return $lang;
}
function errorMessages($errors = [])
{
  $error = [];
  foreach ($errors->toArray() as $key => $value) {
    foreach ($value as $messages) {
      $error[$key] = $messages;
    }
  }
  return $error;
}
function getUserType($id)
{
  return (new User)->where('id', $id)->value('user_type');
}
function getAdminEmail()
{
  return (new User)->where('user_type', '1')->value('email');
}
function getEmail($id)
{
  return (new User)->where('id', $id)->value('email');
}
function mainUserId($id, $user_type)
{
  if ($user_type == 2 || $user_type == 3) {
    return DB::table('trainers')->where('id', $id)->value('user_id');
  } elseif ($user_type == 4) {
    return DB::table('trainees')->where('id', $id)->value('user_id');
  }
}
function getMimeType($filename)
{
  $mimetype = false;
  $mimetype = mime_content_type($filename);
  return $mimetype;
}
function fromEmail()
{
  return 'anju.sharma045@gmail.com';
}
function adminEmail()
{
  return 'anju.sharma045@gmail.com';
}
function apiUrl()
{
  return 'https://reselljunkie.com/';
}
function sendMail($to, $subject, $view)
{
  $email = new \SendGrid\Mail\Mail();
  $email->setFrom(fromEmail(), config('app.name'));
  $email->setSubject(config('app.name') . $subject);
  $email->addTo($to);
  $email->addContent("text/html", $view);
  $sendgrid = new \SendGrid(config('services.sendgrid.api_key'));
  try {
    $response = $sendgrid->send($email);
  } catch (Exception $e) {
    echo 'Caught exception: ' . $e->getMessage() . "\n";
  }
}

function getStartingMonth()
{
  return 3;
}
