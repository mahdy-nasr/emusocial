<?php
function passedTime($date_string) 
{
	//echo time()-strtotime($date_string);die;
	$time_passed = time() - strtotime($date_string);
	$ext = 'second';

	if ($time_passed > 59) { 
		$time_passed = intdiv($time_passed,60);
		$ext = 'minute';
	}
	if ($ext=='minute' && $time_passed > 59) {
		$time_passed = intdiv($time_passed,60);
		$ext = 'hour';
	}
	if ($ext=='hour' && $time_passed > 23) {
		$time_passed = intdiv($time_passed,24);;
		$ext = 'day';
	}
	if ($ext=='day' && $time_passed > 30) {
		$time_passed = intdiv($time_passed,30);;
		$ext = 'month';
	}

	if ($ext=='month' && $time_passed > 356) {
		$time_passed = intdiv($time_passed,356);;
		$ext = 'year';
	}

	if ($time_passed > 1)
		$ext.='s';
		return $time_passed.' '.$ext;
}