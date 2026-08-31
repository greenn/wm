<?#3.9.2

_needphp(
	'pcss',
	'css/clamp',
	'css/clamp2',
	'hex-rgb', 'css/cbn', 'css/dec',
	'pl', 'valArray'
);

/*
b - ярче
с - контраст
d - темнее

l - светлее
m - тусклее

p - бледно- / еле (pale)
s - насыщенный

*/

class _css {

	static $db = array();




	static function init($cfg = array()){

		$cssPrm = static::getSubData($cfg, 'prm'); //настройки сайта
		$cssCommon = static::getSubData($cfg, 'common', static::_cssCommon()); //общие частые настройки
		$cssColors = static::getSubData($cfg, 'colors'); //палитра сайта
		$cssFonts = static::getSubData($cfg, 'fonts'); //фонты сайта

		//dx($cssPrm, $cssCommon, $cssColors, $cssFonts); //а здесь $cssFonts уже снова string

		$cssSettings = array_merge($cssPrm, $cssCommon, $cssColors, $cssFonts['data']);
		//dx($cssPrm, $cssCommon, $cssColors, $cssFonts['data'], $cssSettings);

		//step: линковка
		$cssData = _css::prepare_set($cssSettings);
		//if (_x('dbg-ck')) dx($cssData);

		//step: расширение
		$cssData += $cssFonts['extend'];

		//step: установка
		//dx($cssSettings, $cssData);
		static::set($cssData);


		//step: подгружаем наборы данных as is (без распазнования и перелинковки)
		$cssPacks =  static::getSubData($cfg, 'packs');
		//if (_x('dbg')) dx($cssPacks);
		if ($cssPacks) {
			static::$db += $cssPacks;
		}


		//step: Media Queries sizes
		$cssMQ =  static::getSubData($cfg, 'mq');
		static::set_mq($cssMQ);
		//dx(_css::$mq);


		//step: Дополнительные CSS (для CMS)
		//include 'acc.php';

	}

	//получаем данные
	static function getSubData($cfg, $prop, $otherwise = array()){
		$data = _prop($cfg, $prop, $otherwise);
		if (is_string($data)) {
			$path = $data;
			if (!is_file($path)) {
				$dir = _prop($cfg, 'dir'); //директория настроек
				$path = "$dir/$path";
			}
			if (is_file($path)) {
				$data = include $path;
			}
		}
		return $data ?: array();
	}

	static function _cssCommon(){
		return array(
			//002
			//'fs0_' => _css::dec(16, 'T'), //mq-адаптация размеров для базового размера текста

			'tr0' => '.3s ease',        // основные transition-настройки (используются почти везде)
			'tr0_t' => '.3s',           // === время из tr0

			'trq1' => '.2s '.cbn('easeOutCirc'),

			'bsh1' => '0 2px 2px 0 rgba(0,0,0,0.14),0 3px 1px -2px rgba(0,0,0,0.12),0 1px 5px 0 rgba(0,0,0,0.2)',
			'sh-c1' => '0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24)',
		);
	}



	static function prepare_set($cssSet){

		//разбор массива ffs на имена, где f% (f1, f2, …) - есть название шрифтов
		//  если они ещё не были указаны

		if (isset($cssSet['ffs'])) {
			foreach ($cssSet['ffs'] as $i => $f) {
				$ff = strpos($f[0], ' ') ? "'{$f[0]}'" : $f[0];
				if (!isset($cssSet["f$i"])) $cssSet["f$i"] = $ff;
				if (!isset($cssSet["f{$i}f"])) {
					$defaultGeneric = prop($cssSet, 'f0', 'sans-serif');
					$generic = prop($f, 'generic', $defaultGeneric); //https://developer.mozilla.org/en-US/docs/Web/CSS/font-family#generic-name
					$cssSet["f{$i}_"] = "$ff, $generic";
				}
			}
		}

		ksort($cssSet);

		return valArrayMap(mapProps($cssSet));
	}

	static function set($cssData){
		static::$db = $cssData;
		//dx(static::$db);
	}


	static function val($name){
		return is_array($name)
			? propChainArg(static::$db, $name)
			: prop(static::$db, $name)
		;
	}



//mq #6.1.1
//6.0.1 - ._/d/mq/6/mq.class.php
	static $mq = array(); //база хранения mq-параметров

	static function set_mq($orgData){ //добавляем в базу значения
		$step1 = valArrayMap($orgData);
		$step2 = mapProps($step1); //обработка pl
		$step3 = valArrayMap($step2);
		$resData = array_replace(static::$mq, $step3);
		//dx(static::$db, $step1, $step1, $resData);
		return static::$mq = $resData;
	}

	static function mq($name) { //получение значения для MQ
		return prop(static::$mq, $name, $name);
	}
	static function mq_() { //получение MQ-значений в виде массива
		$res = array();
		foreach (func_get_args() as $key => $name) {
			$res[$key] = static::mq($name);
		}
		return $res;
	}
//\

	//static $GoogleFonts = 'v2'; //0  / man https://developers.google.com/fonts/docs/css2
	//https://fonts.googleapis.com/css2?family=Comfortaa&amp;text=Hello%c2%a1

	//static $GoogleFontsPreconnect = true;
	static $GoogleFontsUrl = 'https://fonts.googleapis.com/css2?';
	static $localFontsUrl = '/fonts';
	/*
		same result
			https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap
			https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100&display=swap
			er: https://fonts.googleapis.com/css2?family=Roboto:wght,ital@100,0&display=swap
				Axes must be listed alphabetically (e.g. a,b,c,A,B,C)
				Roboto:wght,ital@100,0

			2023-12-16 JetBrains Mono
				<link rel="preconnect" href="https://fonts.googleapis.com">
				<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
				<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
	*/

	static function googleFontsLinks($ffsData = true){
		if ($ffsData === true) $ffsData = static::val('ffs');
		if (!$ffsData) return '';
		//dx($ffsData);

		$familyCache = array();
		$familyStack = array();
		foreach ($ffsData as $n => $fontCfg) {
			if (prop($fontCfg, 'local')) continue; //case: skip local
			$ff = $fontCfg[0];
			if (isset($familyCache[$ff])) continue; else $familyCache[$ff] = true;
			$googeCfg = "family=$ff";
			//$googePrm = array();
			if ($_wght = prop($fontCfg, 'wght')) {
				$wght = array();
				foreach(explode(',', $_wght) as $set) {
					$val = array();
					$italicMode = substr($set, -1);
					$isItalic = $italicMode === 'i';
					$val []= $isItalic ? '1' : '0'; //ital
					$val []= $isItalic ? substr($set, 0, -1) : $set; //wght
					$wght []= join(',', $val);
				}
				sort($wght);
				$wght = join(';', $wght);
				$googeCfg .= ":ital,wght@$wght";
			}
			$familyStack []= $googeCfg;
		}

		//dx($familyStack);
		if (!$familyStack) return '';

		$linkUrl = join('', array(
			static::$GoogleFontsUrl,
			join('&', $familyStack),
			//'&display=swap'
			'&display=block'
		));
		//dx(css('ffs'), $linkUrl, $familyStack, static::$db);
		if (!Online) return '';
		return  <<<html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="$linkUrl" rel="stylesheet">
html
		;
	}

/*
	filter - 300,400,600,700
	subset - cyrillic,cyrillic-ext
	display - swap [oo web/inc/css/tpl/font.css.php:49]
	[dz] range - cyrillic-ext
	--inf
		? vfix
		? hinted
*/
	static function localFontsLinks($ffsData = true){
		if ($ffsData === true) $ffsData = static::val('ffs');

		$familyCache = array();
		$links = array();
		if ($ffsData) foreach ($ffsData as $n => $fontCfg) {
			if (!prop($fontCfg, 'local')) continue; //case: skip non-local css files
			$set = array();
			$nf = $fontCfg['local']; //filename
			if (isset($familyCache[$nf])) continue; else $familyCache[$nf] = true;
			//$ff = $fontCfg[0]; //font-family

			$set['filter'] = prop($fontCfg, 'wght');
			$set['display'] = prop($fontCfg, 'display', 'swap');

			
			$prm = array();
			foreach ($set as $key => $val) {
				if ($val) {
					$prm []= "$key=$val";
				}
			}
			$url = static::$localFontsUrl."/$nf.css.php?".join('&', $prm);
			if (1) $url = '//'.site('hostName').$url;
			$links []= "<link href=\"$url\" rel=\"stylesheet\" />";
		}
		return join(newline, $links);
	}

	static function rawFontsLinks($ffsData = true){
		if ($ffsData === true) $ffsData = static::val('ffs');

		$links = array();
		if ($ffsData) foreach ($ffsData as $n => $fontCfg) {
			if ($url = prop($fontCfg, 'raw')) {
				$url = qv($url);
				$links []= "<link href=\"$url\" rel=\"stylesheet\" />";
			}
		}
		return join(newline, $links);
	}

	static function fontsLinks($ffsData = true){

		return join(newline, array(
			static::rawFontsLinks($ffsData),
			static::localFontsLinks($ffsData),
			static::googleFontsLinks($ffsData),
		));
	}



	/*
	    oo
			_/php/css/font_url.dp.php
		dd
			iq/config/css.php
			rp/page/-page.tpl.php
			eg web/inc/css/font_use.eg.php

		ug
			$ffs = array(
				'1' => _css::fontUrl(array(
					'url' => 'https://fonts.googleapis.com/css2?family=Roboto',
					'filter' => array()
				))
			)
	*/
	static function font_url($cfg){
		static $f_display = array('swap', 'block', 'optional', 'fallback', 'auto');

		$urlStart = $cfg['url'];
		$filter = $cfg['filter'];

		$prmFilter = is_string($filter)? $filter : join(';', $filter);
		return $urlStart.$prmFilter.'&display='.$f_display[0];
	}

#< site_css
	//процентальное уменьшение для MQ
	//T - fs (texts / line-height)
	//S - p/m (sizes)

	const DEC_T1 = 10;
	const DEC_T2 = 20;
	const DEC_T1B = 17;
	const DEC_T2B = 28;
	const DEC_S1 = 20;
	const DEC_S2 = 40;
	const DEC_S1B = 35;
	const DEC_S2B = 50;


	static function dec($value, $decMode = 'T', $addValues = false){
		static $CSS_MQ_DEC_MODE = array(
			'T'  => array(true, _css::DEC_T1, _css::DEC_T2),
			//'B1' => array(true, _css::DEC_T1, _css::DEC_T2),
			'T2' => array(true, _css::DEC_T1B, _css::DEC_T2B),
			'S'  => array(true, _css::DEC_S1, _css::DEC_S2),
			//'ST1' => array(true, _css::DEC_S1, _css::DEC_S2),
			'S1' => array(true, _css::DEC_S1B, _css::DEC_S2B),
			'R' => array(
				'0' => true, '1' => 33, '2' => 60,
				'1b' => 20, '1c' => 27, '2b' => 45,
				'3' => 65, '4' => 67,
				'-' => 67, '-b' => 70,
			),
		);
		$decData = is_array($decMode) ? $decMode : prop($CSS_MQ_DEC_MODE, $decMode);
		$resData = dec_($value, $decData);
		if ($addValues) {
			foreach ((array)$addValues as $index => $value) {
				if (is_numeric($index)) {
					$resData []= $value;
				} else {
					$resData[$index] = $value;
				}
			}
		}
		return $resData;
	}

	//01
	static function dec_vw($value, $decMode = 'S', $mqVals = true, $precision = 4){
		if ($mqVals === true) $mqVals = static::mq_(1, 2, 3);
		$resData = array();
		$data = is_array($value) ? $value : _css::dec($value, $decMode);
		foreach ($mqVals as $index => $MQ) {
			$val = $data[$index];
			if (is_numeric($MQ)) {
				$val = _vw($val, $MQ, $precision);
			}
			$resData[$index] = $val;
		}
		return $resData;
	}



	//oo ._/man/php/css.class:78
	static function use_vw($max_value, $MQX = true, $min_value = _css::DEC_S2B, $isDecType = true){
		$data = array();
		$data[0] = $max_value.'px';

		if (!is_array($MQX)) { //рафинат
			$vw_precision = 4;
			if ($MQX <= $vw_precision) { //изюм-1
				$vw_precision = $MQX;
				$MQX = true;
			}
			if ($MQX === true) $MQX = _css::mq('max');
			$MQX = array($MQX, $vw_precision);
		}

		$data[1] = _vw($max_value, $MQX[0], $MQX[1]);

		$data[2] = $min_value;
		if ($isDecType) { //изюм-2
			$decType = $min_value;
			$data[2] = _dec($max_value, $decType);
		}
		$data[2] .= 'px';

		return $data;
	}

	/*
		конструкция для получения набора mq-css-значений
		результат массив данных
		0 - px размер для mqX
		1 - vw значение до mqZ
		2 - px мин-значение (mqZ)
	*/
	static function use_px($val1, $val2, $MQ = true){
		if ($MQ === true) $MQ = static::mq('max');
		return set_px($val1, _vw($_sn = $val2, $MQ, 4), $_sn);
	}

	//[c4 для быстрой смены __css::use_px(80, '', 0);
	//static function __css::use_px($val_max, $val_vw, $val_min) {
	//return set_px_(func_get_args());
	//}


	//для "безхозных"-args ставим px
	static function set_px(/*a, r, g, s*/){ //|set_px|upd_px|
		$data = func_get_args(); //|$dataset|$data
		foreach ($data as &$value) {
			if (is_numeric($value)) $value .= 'px';
		}
		return $data;
	}
	static function set_px_($Args){
		return call_user_func_array('set_px', $Args);
	}

	static function clamp($value, $minValue, $mqMax = true, $mqMin = true, $unit = true){
		if (is_string($mqMax)) $mqMax = _css::mq($mqMax);
		if (is_string($mqMin)) $mqMin = _css::mq($mqMin);
		if ($mqMax === true) $mqMax = _css::mq('site');
		if ($mqMin === true) $mqMin = _css::mq('min');
		return _clamp2($value, $minValue, $mqMax, $mqMin, $unit);
	}
}

/*
function _css($name){
	$arg = func_num_args() > 1 ? func_get_args() : $name;
	return _css::val($arg);
}
/*[01] function _css_cv($name){ //color-value
	return ltrim(_css($name), '#');
}*/

function _cssvarname($name){
	$name = str_replace(' ', '_', $name);
	//$name = preg_replace('/[^a-z0-9\-]/i', '_', $name);
	return "--$name";
}
function _cssvar($name){
	$name = _cssvarname($name);
	return "var($name)";
}

//ak cssvarpack
/*eg
	_csspack('background-color: %;', 'CSSPACK_COLORS12')
*/
function _csspack($pattern, $pack){
	$res = array();
	if (is_string($pack)) {
		$pack = _css($pack);
	}

	foreach ($pack as $name) {
		$res []= str_replace('%', _cssvar($name), $pattern);
	}

	return join(newline, $res);
}
function _mq($name){
	return _css::mq($name);
}
/*
	mb / но пока нет смысла
		max-width: <?=_mq(1) - 10*2?>px;
        max-width: <?=_mq(1, - 10*2)?>px;
*/

function _fs($id, $prop){
	//return css('fs_', $id, $prop);
	static $_fs = array(); if (!$_fs) $_fs = css('fs_');
	if ($prop == 'fc') $prop = array('nc', 0);
	if ($prop == 'fs') $prop = array('fs', 1);
	$fCfg = prop($_fs, $id);
	return prop($fCfg, $prop);
}
	/*  eq:
			css('fs_', 's', 'fh')
			_fs('s', 'fs')
	*/

function _fs_vw($mqName, $id, $prop = 'fs'){
	//return _vw(css('fs_', $id, $prop), _mq($mqName), 2);
	return _vw(_fs($id, $prop), _mq($mqName), 2);
}
	/*  eq:
			_vw(css('fs_', 'hg', 0), _mq(1), 2)
			_vw(_fs('s', 'fs'), _mq(1), 2)
			_fs_vw(1, 's')
	*/


/*
	MQ eg:

	//const MQ6 => 1980,
	//const MQ1D => 1920,
	'max' => 1832, //$MQX,
	'plan' => 1800, //$MQX,
	//const MQ1E => 1600,
	//const MQ1C => 1366,
	//const MQ1B => 1280,
	//'MQ1' => 1214, //MQ1
	//'1' => 1214, //MQ1
	'1' => 1214, //MQ1
	'base' => '1',
	//'header' => 1214,
	'header' => '1',
	//static $_MQ1,
	//static $MQ_S,
	//static $_MQ_S,
	'2++' => 960, // 2-- / 2++ / 26
	'2+' => 877, //MQ2C / 2-2 / 2+ / 2- / 23
	'2' => 810, //MQ2
	'3+' => 667, //MQ3B
	'3' => 480, //MQ3
	//const MQ4 => 414,
	//const MQ0B => 360,
	//const MQ0 => 300,
	'min' => 360,
	//static $_MQ0,
	//static $MQZ,

*/


/*
	prm eg:

	//const MQ6 => 1980,
	//const MQ1D => 1920,
	'max' => 1832, //$MQX,
	'plan' => 1800, //$MQX,
	//const MQ1E => 1600,
	//const MQ1C => 1366,
	//const MQ1B => 1280,
	//'MQ1' => 1214, //MQ1
	//'1' => 1214, //MQ1
	'1' => 1214, //MQ1
	'base' => '1',
	//'header' => 1214,
	'header' => '1',
	//static $_MQ1,
	//static $MQ_S,
	//static $_MQ_S,
	'2++' => 960, // 2-- / 2++ / 26
	'2+' => 877, //MQ2C / 2-2 / 2+ / 2- / 23
	'2' => 810, //MQ2
	'3+' => 667, //MQ3B
	'3' => 480, //MQ3
	//const MQ4 => 414,
	//const MQ0B => 360,
	//const MQ0 => 300,
	'min' => 360,
	//static $_MQ0,
	//static $MQZ,

*/

/*
	fonts eg:
	//Thin 100 / Extra-light 200 / Light 300
	// Regular 400 / Medium 500 /Semi-bold 600
	// Bold 700 / Extra-bold 800 / Black 900

	//S - serif / с засечками
	//SS - sans-serif / без засечек
	//K - cursive


*/


