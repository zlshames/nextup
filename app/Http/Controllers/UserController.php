<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
