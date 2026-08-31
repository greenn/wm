<?#2.7
// про время

/* #6.25
	использование date c реальным значением микросекунд
*/
function udate($datePattern, $mktime = true){
	if ($mktime === true) $mktime = microtime();
	if (strpos($mktime, ' ') !== false) { # for microtime()
		list($mc, $time) = explode(' ', $mktime);
		$datePattern = str_replace('u', (int)substr($mc, 2 , 6), $datePattern);
		return date($datePattern, (int)$time);
	} else {
		if (strpos($mktime, '.') !== false) { # for microtime(true)
			$mktime = number_format($mktime, 6, '.', '');
			$dateObj = DateTime::createFromFormat('U.u', $mktime);
		} else { # for mktime()
			$dateObj = DateTime::createFromFormat('U', $mktime);
		}
		return $dateObj ? $dateObj->format($datePattern) : $mktime;
	}
	/*
		== udate("{y-m-d(H:i:s.u)}", microtime()),
		    udate("{y-m-d(H:i:s.u)}", microtime(true)),
		    udate("{y-m-d(H:i:s.u)}", time())
	*/
}


/*
	количество в секундах до указанной даты в формате для strtotime (http://php.net/manual/ru/datetime.formats.relative.php#gtx-trans)
	если дата прошла, то возвращает или 0 или отрицательное число (если не выставлен флаг $zeroMin)
		ts_until('2017-10-08 5:30:00')
		ts_until('next sunday')
		ts_until(array('next day', '+5 hour'))

*/
function ts_until($time, $zeroMin = true){

	$to = 0;
	$tStack = is_array($time) ? $time : array($time);
	foreach ($tStack as $tConf) $to += strtotime($tConf);

	if (!$to) return 0;

	$date = $to - time();
	return $date >= 0 ? $date : ($zeroMin ? 0 : $date);
}


//время в секундах
/*function t_s($set){
	if (is_array($set)) {
		if (prop($set, 'until')) {

		}
	}
}*/

#0.3
//RFC_WTA17 - значения идут с последующим пробелом
function tm_ago($timestamp, $start_timestamp = true, $pattern = '%Y%m%d%H%i%s', $rfc = 'RFC_WTA17'){ //web(v17)-tm_ago
	if ($start_timestamp === true) $start_timestamp = time();

	$Start = DateTime::createFromFormat('U', $start_timestamp);
	$Date = DateTime::createFromFormat('U', $timestamp);

	$interval = $Start->diff($Date);

	$tr = array();

	$Y = $interval->format('%Y');
	$tr['%Y'] = '';
	if ($Y !== '00') {
		$tr['%Y'] = $Y.(preg_match('~(5|6|7|8|9|0|11|12|13|14|15|16|17|18|19)$~', ltrim($Y, '0'))? 'лет' : 'г').' ';
	}

	$m = $interval->format('%m');
	$tr['%m'] = $m !== '0' ? $m.'м ' : '';

	$d = $interval->format('%d');
	$tr['%d'] = $d !== '0' ? $d.'д ' : '';

	$H = $interval->format('%H');
	$tr['%H'] = $H !== '00' ? ltrim($H, '0').'ч ' : '';

	$i = $interval->format('%i');
	$tr['%i'] = $i !== '0' ? $i.'мин ' : '';

	$s = $interval->format('%s');
	$tr['%s'] = $s !== '0' ? $s.'сек ' : '';
	//d($Y, $m, $d, $H, $i, $s, $res);

	$res = rtrim(strtr($pattern, $tr));

	return $res;
}