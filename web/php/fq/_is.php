<?#2.3.1

function is_digit($var){ return is_integer($var) || is_float($var); }

/*  oo web/test/web/php/fq/is_valuable.php
	по идеи, это проверка на наличия значимого значения
		не false / не empty() / не null / и? не true
	а так же тех которых перечислена дополнительно
		is_valuable($arg, 0)
	но как-будто что-то нето, особенно первая проверка
		!is_true($var) - wtf
*/
function is_valuable($var){ //|is_value|is_any|is_valuable
	$res = $var && !empty($var) && !is_true($var);
	if (func_num_args() > 1) {
		$args = array_slice(func_get_args(), 1);
		foreach ($args as $arg) {
			$res += $var === $arg;
		}
	}
	return !!$res;
}

function is_mixed($var){ return is_array($var) || is_object($var); }

function is_stringable($var){ return is_string($var) || is_numeric($var); }

function is_stringed($var){ return (is_string($var) && !empty($var)) || is_numeric($var); }

function is_true($var){ return $var === true; }

function is_false($var){ return $var === false; }

function is_number($var){ return is_integer($var) || is_float($var); }

//function is_null() //is php:is_null

function is_true_or_numeric($var){ return $var === true || is_numeric($var); }

function is_true_or_stringable($var){ return $var === true || is_stringable($var); }

function is_array_or_stringable($var){ return is_array($var) || is_stringable($var); }

function is_null_or_false($var){ return is_null($var) || $var === false; }

function is_bool_or_null($var){ return is_bool($var) || is_null($var); }

//_addphp('fq/is/is_ordinal');

function is_propData($var){ return is_array($var) || is_stringed($var); }

/*
	на сладкое
	eg
		'uc_until' => !isMe ? '2021-02-03 11:00' : false,
		'uc_until' => isnot(isMe, '2021-02-03 11:00'),
*/
function isnot($condition, $then, $else = false) {
	return !$condition ? $then : $else;
}