<?#0.4.0
//ts web/test/php/formatSec.php

function formatSec($totalSec, $is_ms = false, $asData = false, $txUnits = true) {
	if ($txUnits === true) {
		$txUnits = array(
			'h' => 'ч',
			'min' => 'мин',
			's' => 'сек',
			'ms' => 'мс',
			'mcs' => 'мс',
		);
	}

	$res = array();

	$totalSec = (float)$totalSec;


	$ms = 0;
	$ums = 0;
	if ($is_ms) {
		$ms = $totalSec % 1000;
		//$ums = ltrim(strstr ($totalSec, '.' ), '.');
		$ums = round(($totalSec - floor($totalSec)) * 1000);

		$totalSec /= 1000;
	} else {
		$tail = round(($totalSec - floor($totalSec)) * 1000000);
		$ms = floor($tail / 1000);
		$ums = $tail % 1000;
	}

	if ($hours = floor($totalSec / 3600)) {
		$res['h'] = $hours;
	}

	//days array_unshift + --hours

	if ($minutes = floor(($totalSec / 60) % 60)) {
		$res['min'] = $minutes;
	}

	if ($seconds = $totalSec % 60) {
		$res['s'] = $seconds;
	}

	if ($ms) {
		$res['ms'] = $ms;
	}
	if ($ums) {
		$res['mcs'] = $ums;
	}

	if (!$asData) {
		$tx = array();
		foreach ($res as $name => $val) {
			$unit = $txUnits && isset($txUnits[$name]) ? $txUnits[$name] : $name;
			$tx []= $val.$unit;
		}
		$res = join(' ', $tx);
	}
	return $res;
}

function formatSec_eng($totalSec, $is_ms = false, $asData = false){
	return formatSec($totalSec, $is_ms, $asData, false);
}

function formatSecHtml($totalSec, $is_ms = false, $format_v = 1){
	static $formats = array(
		1 => '<sup>$1</sup>',
		2 => '<sub>$1</sub>',
		3 => '<span style="margin-left: 1px;">$1</span>',
	);
	$format = isset($formats[$format_v]) ? $formats[$format_v] : $formats[1];
	$data = formatSec($totalSec, $is_ms, true);
	foreach ($data as &$value) {
		$value = preg_replace('~([^\d]+)~', $format, $value);
	}
	return join(' ', $data);
}

//$is_ms - время ($totalSec) заданно в милисекундах
function formatSecDate($totalSec, $is_ms = false, $format = 'H:i:s') {
	$totalSec = (float)$totalSec;
	if ($is_ms) $totalSec /= 1000;
	$res = gmdate($format, $totalSec); //round($totalSec)
	return $res;
}