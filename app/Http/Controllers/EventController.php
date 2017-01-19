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

				// Do logic here
		}

		// GET
		public function show(Request $request, $id)
		{
				if ($id == "all") {
					$events = Event::all();
					if (sizeof($events) > 0) {
						return Larapi::ok($events);
					}
					return Larapi::noContent();
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

		}

		// DELETE
		public function destroy(Request $request, $id)
		{

		}
}
