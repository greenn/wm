<?#0.1.1

class code {

	static $newLine = '<br />'; //'<br />' / newline
	static $space = '&nbsp;'; //'&nbsp;' / ' '
	static function outputView($type/*'inline', 'html'*/){}


	static $baseShiftTime = 4;

	static function shift($shiftTime, $string){
		$baseShift = str_repeat(static::$space, static::$baseShiftTime);
		$shift = str_repeat($baseShift, $shiftTime);
		$rec = $shift . $string;
		return $rec;
	}

	static function _inset(&$stack, $string, $shift = 0){
		$stack []= static::shift($shift, $string);
	}

	static function as_string($data, $shiftTimer = 0){
		//if (is_true)
		//is_array($value) ? static::as_array($value, $shiftTimer + 1) : var_export($value, true);

	}
	static function as_array($data, $shiftTimer = 0, $noStartShift = false){
		$output = array();
		if (is_array($data)) {
			static::_inset($output, 'array(', $noStartShift ? 0 : $shiftTimer);

			end($data); $lastKey = key($data);
			foreach ($data as $key => $value) {
				if (is_array($value)) {
					$rec_val = static::as_array($value, $shiftTimer + 1, true);
					$rec_val = rtrim($rec_val, ';');
				} else {
					$rec_val = var_export($value, true);
				}
				$rec = "'$key' => $rec_val";
				if ($key !== $lastKey) $rec .= ',';
				static::_inset($output, $rec, $shiftTimer + 1);
			}
			static::_inset($output, ');', $shiftTimer);
		}
		return join(static::$newLine, $output);
	}

}

