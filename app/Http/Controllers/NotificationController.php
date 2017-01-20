<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Larapi;

use App\Notification;
use App\Http\Controllers\AuthController;

class NotificationController extends Controller
{
  public function store(Request $request)
  {
  	$user = AuthController::getUser($request);
  	if ($user == NULL) {
  		return Larapi::forbidden();
  	}

  	if (!$request->event_id || !$request->notify_at) {
  		return Larapi::badRequest();
  	}

  	$notification = new Notification;

  	$notification->event_id = $request->event_id;
  	$notification->user_id = $request->user_id;
  	$notification->notify_at =  $request->notify_at;

  	if($request->finish) {
  		$notification->finish = $request->finish;
  	}

  	$notification->save();
  	return Larapi::created($notification);
  }

  public function show($id)
  {
  	if ($id == "all") {
  		$notifications = Notification::all();
  		return Larapi::ok($notifications);
  	}

    if (!is_numeric($id)) {
  		return Larapi::badRequest("The ID must be numeric.");
  	}

  	$notification = Event::find($id);
  	if ($notification == NULL) {
  		return Larapi::notFound("Unable to find Notification by ID.");
  	}

  	return Larapi::ok($notification);
  }

  public function update(Request $request, $id)
  {
  	$user = AuthController::getUser($request);
  	if ($user == NULL) {
  		return Larapi::forbidden();
  	}

    if (!is_numeric($id)) {
  		return Larapi::badRequest("The ID must be numeric.");
  	}

  	$notification = Notification::find($id);
    if ($notification == NULL) {
  		return Larapi::notFound("Unable to find Notification by ID.");
  	}

  	if ($request->notify_at != null) {
  		$notification->notify_at = $request->notify_at;
  	}

  	$notification->save();
  	return Larapi::accepted($notification);
  }

  public function destroy(Request $request, $id)
  {
    $user = AuthController::getUser($request);
  	if ($user == NULL) {
  		return Larapi::forbidden();
  	}

  	if (!is_numeric($id)) {
  		return Larapi::badRequest("The ID must be numeric.");
  	}

    // MUST CHECK IF USER IS OWNER OF NOTIFICATION

  	$notification = Notification::find($id);
    if ($notification == NULL) {
  		return Larapi::notFound("Unable to find Notification by ID.");
  	}

  	$notification->delete();

    return Larapi::ok($notification);
  }
}
