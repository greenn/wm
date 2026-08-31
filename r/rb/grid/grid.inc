<?
x('rp_grid', array(
	'baseDir' => dirname(__FILE__),
	'nc' => array(
		'base' => 'Gd'
	)
));

class rp_grid extends site_rp {
	static $x = 'rp_grid';

	static function get_content($data, $tplName = null, $rpName = null){
		$content = $data;
		if ($tplName) {
			$tplCtx = $data;
			if ($rpName) {
				$content = rp_tpl($rpName, $tplName, $tplCtx);
			} else {
				$content = static::tpl($tplName, $tplCtx);
			}
		}
		return $content;
	}

	static function cssTpl($name, $ctx = false, $ext = 'tpl.css.php'){
		$result = parent::cssTpl($name, $ctx, $ext);
		//if (startsWith($name, 'grid-')) {
			if ($mq = prop($ctx, '_mq')) { //result-wrapping MQ
				if (is_array($mq)) {
					$mq1 = static::alignUnit($mq[0]);
					$mq2 = static::alignUnit($mq[1]);
					$mq_rule = "(min-width: $mq1) and (max-width: $mq2)";
				} else {
					$mq = static::alignUnit($mq);
					$mq_rule = "(max-width: $mq)";
				}
				$result = join(newline, array(
					"@media $mq_rule {",
						$result,
					'}'
				));
			}
		//}
		return $result;
	}

	//выделить числовое значение и единицу-измерения
	static function extractUnit($value) { //|splitUnit|extractUnit|
		$digit = intval($value);
		$unit = preg_replace('~\d~', '', $value);
		return array(0 => $digit, 1 => $unit, 'val' => $digit, 'unit' => $unit);
	}

	//выровнить значение, чтобы оно было с единицей измерения
	static function alignUnit($val){ //|setUnit|autoUnit|alignUnit|
		///if (!$val) $val = 0; #uuu
		if (is_numeric($val)) $val .= 'px';
		return $val;
	}
	static function alignUnitEach($list){
		//dpx($list);
		//$list = func_get_args();
		foreach ($list as $index => $val) {
			$list[$index] = static::alignUnit($val);
		}
		return $list;
	}
	

	static function calcSideValue($value, $getHalf, $data, $data_/*$extractedData*/ = false){
		if ($value === true) $value = $data;
		if ($value === null && $getHalf) { //case, если не передано значение ss (умолчанию оно null), оно может быть сбрасывающим ss = false
			if (!$data_) $data_ = static::extractUnit($data);
			$value = round($data_['val'] / 2, 2).$data_['unit'];
		}
		return static::alignUnit($value);
	}
	
}