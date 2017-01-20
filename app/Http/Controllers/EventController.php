<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Larapi;

use App\Event;
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

		if (!$request->name || !$request->start || !$request->category_id) {
			return Larapi::badRequest();
		}

		$event = new Event;

		$event->name = $request->name;
		$event->start = $request->start;
		$event->category_id =  $request->category_id;

		if ($request->finish) {
			$event->finish = $request->finish;
		}

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

		// MUST CHECK IF USER IS OWNER OF EVENT

		$event = Event::find($id);
		if ($event == NULL) {
  		return Larapi::notFound("Unable to find Event by ID.");
  	}

		if ($request->name != null) {
			$event->name = $request->name;
		}
		if ($request->start != null) {
			$event->start = $request->start;
		}
		if ($request->finish != null) {
			$event->finish = $request->finish;
		}
		if ($request->category_id != null) {
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

		// MUST CHECK IF USER IS OWNER OF EVENT

		$event = Event::find($id);
		if ($event == NULL) {
  		return Larapi::notFound("Unable to find Event by ID.");
  	}

		$event->delete();

		return Larapi::ok($event);
	}
}
