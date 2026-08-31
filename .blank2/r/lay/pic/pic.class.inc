<?

_lay::reg('pic', array(
	'nc' => array(
		'base' => 'pc'
	),
));

class lay_pic extends lay {
	static function applyCtx($ctx, $defCtx = array()){
		$html = '';
		if ($ctx) {
			if (is_string($ctx)) {
				$ctx = array('uri' => $ctx);
			}

			//if (!is_array($ctx)) $ctx = array(); //case: true
			if ($ctx === true) $ctx = array(); //case: true

			if ($defCtx) {
				//$ctx = array_replace($defCtx, $ctx);
				$ctx += $defCtx;
			}

			if (isset($ctx['html'])) {
				$html = $ctx['html'];
			} else {

				if (!isset($ctx['tpl'])) {
					$ctx['tpl'] = 'img';
				}

				$html = static::tpl($ctx['tpl'], $ctx);
			}

		}

		return $html;
	}

}
