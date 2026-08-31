<?#0.3.2


function parseUnitValue($value, $defUnit = false) {
	if (is_numeric($value)) {
		return [$value, $defUnit];
	} elseif (preg_match('/^(\d+(?:\.\d+)?)(\D+)$/', $value, $matches)) {
		return [(float)$matches[1], $matches[2]];
	}
	return $value; // если не число, вернуть как есть
}


	function parsePctValue($input, $defUnit = false) {
		if (is_numeric($input)) {
			return array(floatval($input), $defUnit);
		}

		$value = str_replace('%', '', $input);
		if (is_numeric($value)) {
			return array(floatval($value), '%');
		}

		return null;
	}




//DD

//ChatGPT-4 Turbo
function parseUnitValue1($value) {
	if (is_numeric($value)) {
		return [$value, ''];
	} elseif (preg_match('/^(\d+(?:\.\d+)?)(\D+)$/', $value, $matches)) {
		return [(float)$matches[1], $matches[2]];
	}
	return [$value, '']; // если не число, вернуть как есть
}

function parsePctValue1($value) {
	if (is_numeric($value)) {
		return [(int)$value, ''];
	} elseif (str_ends_with($value, '%')) {
		return [(int) rtrim($value, '%'), '%'];
	}
	return [$value, ''];
}


//Claude 3.5 Sonnet
// Вариант 1: с помощью preg_match
function parseValueAndUnit($input) {
	if (is_numeric($input)) {
		return array(floatval($input), null);
	}

	if (preg_match('/^(-?\d+\.?\d*)\s*(.*)$/', $input, $matches)) {
		return array(
			floatval($matches[1]),
			$matches[2] ?: null
		);
	}

	return array(null, null); // или выбросить исключение
}

