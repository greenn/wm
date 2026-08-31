<?#0.0.3

define('ARRAY_UPDATE__DEFAULT_RULES', array(false, null, ''));

function array_update($source, $extend, $rules = ARRAY_UPDATE__DEFAULT_RULES){
	if (!is_array($source)) $source = array();
	foreach ($extend as $name => $value) {
		$hasProp = array_key_exists($name, $source);
		$matchRule = $hasProp && in_array($source[$name], $rules);
		if (!$hasProp || $matchRule) {
			$source[$name] = $value;
		}
	}
	return $source;
}
function _array_update(&$source, $extend, $rule = ARRAY_UPDATE__DEFAULT_RULES){
	$source = array_update($source, $extend, $rule);
}