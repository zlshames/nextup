<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Larapi;
use Validator;

use App\Event;
use App\Category;
use App\Http\Controllers\AuthController;

class EventController extends Controller
{
	// POST
	public function store(Request $request)
	{
		$user = AuthController::getUser($request);
		if ($user == NULL) {
			return Larapi::forbidden();
		}

		$validator = Validator::make(
      $request->all(),
      Event::$validation_rules,
      Event::$validation_messages
    );

    if ($validator->fails()) {
      return Larapi::badRequest($validator->messages()->toArray());
    }

		$event = new Event;

		$event->user_id = $user->id;
		$event->name = $request->name;
		$event->start = $request->start;

		if ($request->finish) {
			$event->finish = $request->finish;
		}

		$event->category_id = $request->category_id;

		$event->save();
		return Larapi::created($event);
	}

	// GET
	public function show($id)
	{
		if ($id == "all") {
			$events = Event::all();
			return Larapi::ok($events);
		}

		if (!is_numeric($id)) {
			return Larapi::badRequest("The ID must be numeric.");
		}

		$event = Event::find($id);
		if ($event == NULL) {
			Larapi::notFound("Unable to find Event by ID.");
		}

		return Larapi::ok($event);
	}

	public function showByDate($date) {
		if ($date == null) {
			return Larapi::badRequest();
		}
		$events = Event::where('start', $date)
			->orderBy('start', 'desc')->get();

		return Larapi::ok($events);
	}

	// PUT
	public function update(Request $request, $id)
	{
		$user = AuthController::getUser($request);
		if ($user == NULL) {
			return Larapi::forbidden();
		}

		if (!is_numeric($id)) {
			return Larapi::badRequest("The ID must be numeric.");
		}

		$validator = Validator::make(
      $request->all(),
      Event::$validation_update_rules,
      Event::$validation_messages
    );

    if ($validator->fails()) {
      return Larapi::badRequest($validator->messages()->toArray());
    }

		$event = Event::find($id);
		if ($event == NULL) {
  		return Larapi::notFound("Unable to find Event by ID.");
  	}

		if ($user->id !== $event->user_id) {
			return Larapi::unauthorized('You must be the owner of the event to edit it.');
		}

		if ($request->name) {
			$event->name = $request->name;
		}
		if ($request->start) {
			$event->start = $request->start;
		}
		if ($request->finish) {
			$event->finish = $request->finish;
		}
		if ($request->category_id) {
			$event->category_id = $request->category_id;
		}

		$event->save();
		return Larapi::accepted($event);
	}

	// DELETE
	public function destroy(Request $request, $id)
	{
		$user = AuthController::getUser($request);
		if ($user == NULL) {
			return Larapi::forbidden();
		}

		if (!is_numeric($id)) {
			return Larapi::badRequest("The ID must be numeric.");
		}

		$event = Event::find($id);
		if ($event == NULL) {
  		return Larapi::notFound("Unable to find Event by ID.");
  	}

		if ($user->id !== $event->user_id) {
			return Larapi::unauthorized('You must be the owner of the event to delete it.');
		}

		$event->delete();

		return Larapi::ok($event);
	}
}
