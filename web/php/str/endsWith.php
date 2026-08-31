<?#0.5.3

//https://stackoverflow.com/questions/834303/startswith-and-endswith-functions-in-php

function endsWith($haystack, $needle) {
	$length = strlen($needle);
	if ($length == 0) {
		return true;
	}
	return (substr($haystack, -$length) === $needle);
}

function mb_endsWith($haystack, $needle){
	$length = mb_strlen($needle);
	if ($length == 0) {
		return true;
	}
	return (mb_substr($haystack, -$length) === $needle);
}

function mb_endsWithAny($haystack, $needles){
	$match = false;
	foreach ($needles as $needle) {
		$match += mb_endsWith($haystack, $needle);
	}
	return $match;
}