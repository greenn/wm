<?#0.3.1

_needphp('gt');

/*
	site_uriOpts [|ak rp_uriOpts]

	опции из адрессной строки
		rp_landing=fake
			означает включённую опцию fake для rp/landing
		rp_landing=fake|sm
			две включённые опции


	tt
		?rp_landing=fake|v=2=a|sz=12&ok
	oo  site/test/site_uriOpt.php?rp_landing=fake|v=2=a|sz=f&ok
*/

//

function site_getUriOpts($opt_parName){
	static $falseData = array('-', 'false');
	static $falseItemData = array('-', 'f', 'false');

	static $trueData = array('', 'true');
	static $trueItemData = array('', 't', 'true');

	$opts = null;

	if (gt_has($opt_parName)){
		$opts = true;

		$optsStr = gt($opt_parName);
		if (in_array($optsStr, $falseData)) {
			$opts = false;
		} elseif (in_array($optsStr, $trueData)) {
			$opts = true;
		} elseif ($optsStr !== '') { //case: not empty value
			$optItems = explode('|', $optsStr);

			if ($optItems) {
				$opts = array();
				foreach ($optItems as $optStr) {
					$optData = explode('=', $optStr, 2);
					$optName = $optData[0];
					$optVal = true;
					if (count($optData) === 2) {
						$optVal = $optData[1];
						if (in_array($optVal, $falseItemData)) {
							$optVal = false;
						} elseif (in_array($optVal, $trueItemData)) {
							$optVal = true;
						}
					}
					$opts[$optName]	= $optVal;
				}
			}
		}
	}

	return $opts;
}

function site_uriOpts($opt_parName){
	static $cache = array(
		'' => null
	);
	if (!is_string($opt_parName)) $opt_parName = '';

	if (!array_key_exists($opt_parName, $cache)) {
		$cache[$opt_parName] = site_getUriOpts($opt_parName);
	}
	return $cache[$opt_parName];
}

function site_uriOpt($opt_parName, $opt_name = null, $opt_val = true){
	$res = null;
	$opts = site_uriOpts($opt_parName);
	$mode = func_num_args();
	if ($mode === 1) {
		$res = (boolean)$opts;
	} elseif ($mode >= 2) {
		$res = prop($opts, $opt_name, null);
		if ($mode === 3) {
			$res = $res === $opt_val;
		}
	}

	return $res;
}


function self_uriParName($callIndex = 1) { //$callIndex - глубина вызова
	$optParName = '';
	if ($RP = self_rp($callIndex)) {
		$optParName = $RP::nc('base');
	}
	return $optParName;
}
function self_uriOpts(){
	$optParName = self_uriParName(2);
	return site_uriOpts($optParName);
}
function self_uriOpt($opt_name = null, $opt_val = true){
	$callArgs = func_get_args();
	array_unshift($callArgs, self_uriParName(2));
	return call_user_func_array('site_uriOpt', $callArgs);
}

/*
	обычно появляется такая строка
	if (site_uriOpt('landing', 'fake') || self_uriOpt('fake'))
		то есть для управления хочется иметь уникальную опцию 〈self_uriOpt('fake')〉
			но конкретно для какой $opt_parName бывает не явно
				[iz site_rp::$DBG_RpName=t]
		поэтому делаем
		rp_siteOpt('landing', 'fake')
			которая и опцию оставляет для себя, а так же имеет дополнительное-выбранное имя
		[u] как-хитро
	[ty]
		rp_uriOpt('landing', 'fake') === (site_uriOpt('landing', 'fake') || self_uriOpt('fake'))

	[hr]
		если есть уже именная настройка, то какой смысл использовать внутренню 〈self_uriOpt('fake')〉
		[po-nv-nsm] а просто юзать 〈site_uriOpt('landing', 'fake')〉
*/
function rp_uriOpt($opt_parName, $opt_name = null, $opt_val = true){
	$callArgs = func_get_args();
	$res_siteOpt = call_user_func_array('site_uriOpt', $callArgs);

	$callArgs[0] = self_uriParName(2);
	$res_selfOpt = call_user_func_array('site_uriOpt', $callArgs);

	return bm($res_siteOpt, $res_selfOpt);
}


