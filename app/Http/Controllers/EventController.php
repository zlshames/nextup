<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Larapi;

use App\Event;

class EventController extends Controller
{
		// POST
		public function store(Request $request)
		{
				$user = Auth::user();
				if ($user === NULL) {
						return Larapi::forbidden();
				}

				if (!$request->name || !$request->start || !$request->category_id) {
					return Larapi::badRequest();
				}

				$event = new Event;

				$event->name = $request->name;
				$event->start = $request->start;
				$event->category_id =  $request->category_id;

				if($request->finish) {
					$event->finish = $request->finish;
				}

				$event->save();
				return Larapi::created($event);
		}

		// GET
		public function show($id)
		{
			if($id == null) {
				return Larapi::badRequest();
			}

			if ($id == "all") {
				$events = Event::all();
				if (sizeof($events) > 0) {
					return Larapi::ok($events);
				}

				return Larapi::noContent();
			}

			if (!is_numeric($id)) {
				return Larapi::badRequest();
			}

			$event = Event::find($id);
			if (sizeof($event) > 0) {
				return Larapi::noContent();
			}
			
			return Larapi::noContent();
		}

		// PUT
		public function update(Request $request, $id)
		{
			if($id == null) {
				return Larapi::badRequest();
			}

			$event = Event::find($id);

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
		public function destroy($id)
		{
			if($id == null) {
				return Larapi::badRequest();
			}

			$event = Event::find($id);
			$event->delete();
		}
}
