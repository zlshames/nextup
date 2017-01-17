<?php

namespace App\Http\Controllers;

use DateTime;
use DateInterval;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get current date
        $currDate = new DateTime();
        // Insert today (Format: January 1, 2017)
        $dates = array($currDate->format('F j, Y'));

        // Insert the next 6 days
        for ($i = 0; $i < 6; $i++) {
            // P1D == 'Plus 1 Day'
            $currDate->add(new DateInterval('P1D'));
            // Add new date
            array_push($dates, $currDate->format('F j, Y'));
        }

        // Return $dates array to view
        return view('home', [
          'dates' => $dates
        ]);
    }
}
