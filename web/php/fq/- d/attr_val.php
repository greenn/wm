<?#1.4.1
//uuu нее чё-то не то | on
//eg web/test/web/php/fq/attr_val.php
function attr_val($attrName = null, $attrVal = null, $attrPrepend = false){
	$res = '';

	if (is_stringable($attrName)) {
		$value = null;

		if (is_stringable($attrVal)) {
			$value = $attrVal;
		}
		if (is_array($attrVal)) {
			$value = join(' ', $attrVal);
		}

		if (is_stringable($value)) {
			$res = "$attrName=\"$value\"";
			if ($attrPrepend) {
				$res = ($attrPrepend === true ? ' ' : $attrPrepend).$res;
			}
		}
	}
	return $res;
}