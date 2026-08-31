<?#4.0.0
//_needphp('isOrdinal');

function isAssoc($arr) {
    if (!is_array($arr) || $arr === array()) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function isOrdinal($arr){ //isNotAssoc|isOrdinal|
    return is_array($arr) && !isAssoc($arr);
}

function isArrayOfArrays($arr) {
	foreach ($arr as $item) {
		if (!is_array($item)) {
			return false;
		}
	}
	return true;
}

function isOrdinalOfArrays($arr){
	if (isOrdinal($arr)) {
		return isArrayOfArrays($arr);
	}
	return false;
}

/*
    #6 http://stackoverflow.com/questions/173400/how-to-check-if-php-array-is-associative-or-sequential#answer-173479

    [eg
        var_dump(isAssoc(array('a', 'b', 'c'))); // false
        var_dump(isAssoc(array("0" => 'a', "1" => 'b', "2" => 'c'))); // false
        var_dump(isAssoc(array("1" => 'a', "0" => 'b', "2" => 'c'))); // true
        var_dump(isAssoc(array("a" => 'a', "b" => 'b', "c" => 'c'))); // true
    ]
*/