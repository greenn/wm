<?#0.1.0

function rand_val($variants, $split_string = false){
	if ($split_string) $variants = explode($split_string, $variants);
	$random_key = array_rand($variants);
	$choose = $variants[$random_key];
	return $choose;
}