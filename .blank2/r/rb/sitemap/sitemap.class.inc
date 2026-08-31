<?

_rb::reg('sitemap', array(
	'nc' => array(
		'base' => 'Smp'
	),
));

class rb_sitemap extends rb {

	static function cb_encode_non_ascii($matches){
		return rawurlencode($matches[0]);
	}

	static function domainUrl($closingSlash = true) {
		$url = hostProtocol.cur_iq('hostName');
		if ($closingSlash) $url .= '/';
		return $url;
	}


	static function collectPages($pageList){
		$conf = array();
		$domainUrl = static::domainUrl(false);

		foreach ($pageList as $pid) {

			$smConf = _page($pid, 'sitemap');
			if ($smConf === false) {
				//case: не добавляем в sitemap из-за page-опции
				//	'sitemap' => false
				continue;
			}

			//dx($smConf);
			$canonicalUri = $pid === pro('opt', 'base_pid') ? '/' : $pid;

			$uri = $canonicalUri;

			$conf[$uri] = array(
				'priority' => 0.5, //по умолчанию
				'changefreq' => prop($smConf, 'changefreq', 'weekly'), //hourly, daily, weekly, monthly, yearly
				'timestamp' => static::getPageEditStatus($pid),
			);
		}
		return $conf;
	}


	static function getPageEditStatus($pid) {
		$list = array();
		$ctxList = _page($pid, 'edit-status');
		if ($ctxList === true) $ctxList = time();
		if (is_numeric($ctxList)) {
			$list []= $ctxList;
		} else if (is_array($ctxList)) {
			//case base:
			foreach ($ctxList as $ctx) {
				if ($ctx === true) $ctx = time();


				if (is_numeric($ctx)) {
					$list []= $ctx;
				} else if (is_string($ctx)) {
					$list[$ctx] = static::getFileEditStatus($ctx);
				} else if (isAssoc($ctx)) {
					if ($callData = prop($ctx, 'call')) {
						list($r, $callName) = $callData;
						$callCtx = _prop($callData, 2);
						$res = site($r, 'call', $callName, $callCtx);
						$list [json_encode($callData)]= $res;
					} else {
						//dx($ctx);
					}
				} else if (isOrdinal($ctx)) { //case: isOrdinal edit-status value / ak siteTplConfig
					list($r, $tplName) = $ctx;
					$path = site($r, 'path', $tplName.'.tpl.php');
					$list[$path] = static::getFileEditStatus($path);
				}
			}
		}
		//dx($pid, $list, max($list), max($list) ?: time());

		return $list && max($list) ?: time();
	}

	static function getFileEditStatus($path){
		$res = null;
		if ($path && file_exists($path)) {
			$res = filemtime($path); //$lastModifiedTime
		}
		return $res;
	}
}
