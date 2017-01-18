<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Larapi;

use App\Http\Event;

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
				// I'm not 100% sure, but try:
				// Event::all();
		}

		// GET
		public function showAll(Request $request)
		{

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
