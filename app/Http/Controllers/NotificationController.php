<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Larapi;

use App\Notification;
use App\Http\AuthController;

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
        if($id == null) {
			return Larapi::badRequest();
		}

		if ($id == "all") {
			$notifications = Notification::all();
			if (sizeof($notifications) > 0) {
				return Larapi::ok($notifications);
			}

			return Larapi::noContent();
		}

		if (!is_numeric($id)) {
			return Larapi::badRequest();
		}

		$notification = Event::find($id);
		if (sizeof($notification) > 0) {
			return Larapi::noContent();
		}

		return Larapi::noContent();
	}

    public function update(Request $request, $id)
    {
		$user = AuthController::getUser($request);
		if ($user == NULL) {
			return Larapi::forbidden();
		}

		if($id == null) {
			return Larapi::badRequest();
		}

		$notification = Notification::find($id);

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

		if($id == null) {
			return Larapi::badRequest();
		}

		$notification = Notification::find($id);
		$notification->delete();

        return Larapi::ok($notification);
    }
}
