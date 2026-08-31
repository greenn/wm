<?#0.5.11

_needphp('gt');
/*
	oo site/php/site_r.php:190
	eg
		'opt' => array(
			'v' => array( //[ug $opt_v = $Self::opt('v'); //?button=v=2]
				'def' => 2,
				'range' => array(1, 2),
			)
		)
*/
class site_prm {
	static $falseData = array('-', 'f', 'false', 'off');
	static $trueData = array('', 't', 'true', 'on');
	static $nullData = array('null');

	static $data = array();
	static function get_data($prm){
		if (!isset(static::$data[$prm])) {
			static::$data[$prm] = static::get_opt($prm);
			//d('get (>get_opt)', $prm, static::$data[$prm]);
		}
		return static::$data[$prm];
	}

	static function has($prm){
		return gt_has($prm);
	}

	static function val($opt, $otherwise = null){
		$val = null;
		$prm = static::get_data($opt);
		return $prm ? $prm['val'] : $otherwise;
	}

	static function valName($opt, $name, $otherwise = null){
		$val = null;
		$prm = static::get_data($opt);
		//d('::valName', $name, $prm, prop($prm['vals'], $name), $otherwise, '==', prop($prm['vals'], $name, $otherwise));
		return $prm ? prop($prm['vals'], $name, $otherwise) : $otherwise;
	}

// получение данных по опциям

		static function get_opt($prm){
			$optData = null;
			//d('::get_opt', $prm, gf_has($prm), gf($prm), $_GET, pageQuery);
			if (gt_has($prm)) {
				$val = gt($prm);
				$optData = array(
					'str' => $val,
					'val' => static::get_val($val),
					'vals' => static::get_vals($val),
				);
			}
			return $optData;
		}

		static function get_val($str){
			$val = $str;
			if (in_array($str, static::$falseData, true)) {
				$val = false;
			} elseif (in_array($str, static::$trueData, true)) {
				$val = true;
			} elseif (in_array($str, static::$nullData, true)) {
				$val = null;
			}
			return $val;
		}

		static $vals_delimeter = '|';
		static function get_vals($str){
			$res = array();
			$items = explode(static::$vals_delimeter, $str);
			foreach ($items as $opt) {
				$data = explode('=', $opt, 2);
				$name = $data[0];
				$val = true;
				if (count($data) === 2) {
					$val = static::get_val($data[1]);
				}
				$res[$name] = $val;
			}
			return $res;
		}

// работа с конфигураций
	//static function cfgOpts() {}
	//static function cfgOpt() {}

	static function cfgOpts($datas, $optPrm) {
		$list = array();
		foreach ($datas as $name => $data) {
			$list[$name] = static::cfgOpt($data, $optPrm, $name);
			//d("($optPrm)$name", $data, '==', $list[$name]);
		}
		return $list;
	}

	//[oo web/test/web/php/rp/opt.php]
	static function cfgOpt($cfg, $optPrm, $name) {

		if (isOrdinal($cfg)) {
			//case: {ao} selection-варианты
			$vals = $cfg;
			$cfg = array('vals' => $vals);
		} elseif (!is_array($cfg)) {
			//case: !{a} = значение по умолчанию
			$defValue = $cfg;
			$cfg = array('def' => $defValue);
		}
		//d("($optPrm)$name", '~', $cfg, isset($cfg['def']));

		//step: генерируем vals из range
		if ($range = prop($cfg, 'range')) {
			if (is_numeric($range)) {
				$range = (integer) $range;
				$range = $range > 0 ? array(0, $range) : array();
			}
			$cfg['vals'] = call_user_func_array('range', $range);
			$cfg['strictVals'] = false;
			//$cfg['resNum'] = true; //ps
		}

		//step: опреджеления значения по умолчанию
		if (!isset($cfg['def'])) {
			$cfg['def'] = true;

			if (is_array(prop($cfg, 'vals'))) {
				$cfg['def'] = reset($cfg['vals']);
				if (isAssoc($cfg['vals'])) {
					$cfg['def'] = key($cfg['vals']);
				}
			}
			if (is_array(prop($cfg, 'range'))) {
				$cfg['def'] = reset($cfg['range']);
			}
		}


		//step: определение значений для prm-данных
		if ($prm = prop($cfg, 'prm')) {
			//case: привязка текущей опции к значению другой prm
			//step: получение значения, если есть переназначенная prm или значение по-умочанию
			$val = site_prm::val($prm, $cfg['def']);
			//d('case1', $val, $prm, $cfg['def'], $cfg);
		} else {
			//case: возможна конфигурация привязки текущенй опции к значениям другой опции
			$prmOpt = prop($cfg, 'prmOpt', $optPrm);
			$prmName = prop($cfg, 'prmName', $name);
			$val = site_prm::valName($prmOpt, $prmName, $cfg['def']);
			//d('valName', $prmOpt, $prmName, $val, $cfg);
			//if ($name === 'bg-full')
			//d('case2', $val, $prmOpt, $prmName, $cfg['def'], $cfg);
		}

		if ($val === '' && $cfg['def'] === '') {
			//не первращем это в true
		} else {
			//normal case
			$val = static::get_val($val);
		}

		//d("($optPrm)$name", '=', $val);//
		//d($val); mb-здесь if (is_numeric($val)) $val = (integer) $val;

		if ($vals = prop($cfg, 'vals')) {
			//if ($name == 'bg') dx('has_vals', $name, $val, $vals, $cfg['def']);
			if (isOrdinal($vals)) {
				//dx($val, $vals, in_array($val, $vals));
				if (!in_array($val, $vals, prop($cfg, 'strictVals', true))) {
					$val = $cfg['def'];
				}
			} else { //case: isAssoc - переопределение полученных значений
				$val = isset($vals[$val]) ? $vals[$val] : prop($vals, $cfg['def'], $cfg['def']);
				//$val = isset($vals[$val]) ? $vals[$val] : $vals[$cfg['def']];
			}
		}

		if ($vals_cb = prop($cfg, 'vals_cb')) {
			if (is_callable($vals_cb)) {
				$val = call_user_func($vals_cb, $val, $cfg, $name, $optPrm);
			}
		}


		return $val;

	}


}

