<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Event;
use Larapi;

class UserController extends Controller
{
  public function index(Request $request)
  {  
    return view('user', [
      //'dates' => $dates
    ]);
  }

  public function other(Request $request, $id)
  {
      return view('user', [
        //'dates' => $dates
      ]);
  }

  public function events(Request $request, $username)
  {
    $user = AuthController::getUser($request);
    if ($user == NULL) {
      return Larapi::unauthorized();
    }

    $user = User::where('username', $username)->first();
    if ($user == NULL) {
			Larapi::notFound("Unable to find user.");
		}

    $events = Event::where('user_id', $user->id)
    ->orderBy('start', 'asc')
    ->get();

		if ($events == NULL) {
			Larapi::notFound("Unable to find Event by this user.");
		}

    return Larapi::ok($events);
  }

  public function show(Request $request)
  {

  }

  public function update(Request $request, $id)
  {

  }

  public function destroy(Request $request, $id)
  {

  }
}
