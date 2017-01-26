<?php

namespace App\Http\Controllers;

use DateTime;
use DateInterval;

use Illuminate\Http\Request;

use App\Event;

class HomeController extends Controller
{
	public function index(Request $request)
	{
		// Create a 'week''
		$week = array();
		// Days can be customized
		$days = $request->input('days') ? $request->input('days') : 7;

		// Add dates to weekly array
		$tempDate = new DateTime();
		for ($i = 0; $i < $days; $i++) {
			if ($i !== 0) {
				$tempDate->add(new DateInterval('P1D'));
			}
			
			array_push($week, array($tempDate->format('F j, Y')));
		}

		// Set/Declare current and last days of the week
		$currDate = new DateTime();
		$lastDate = new DateTime();
		$lastDate->add(new DateInterval('P' . ($days - 1) . 'D'));

		// Get events for the week
		$events = Event::whereBetween('start', [$currDate, $lastDate])
			->oldest('start')
			->get();

		// Iterate over each 'day' of the week
		for ($i = 0; $i < sizeof($week); $i++) {
			$wDate = new DateTime($week[$i][0]);

			// Iterate over events and insert where dates match
			foreach ($events as $event) {
				$eDate = new DateTime($event->start);

				if ($eDate->format('F j, Y') == $wDate->format('F j, Y')) {
					array_push($week[$i], json_encode([
						'name' => $event->name,
						'start' => $event->start,
						'category' => $event->category_id
					]));
				}
			}
		}

		// Return $week array to view
		return view('home', [
			'week' => $week
		]);
	}
}
