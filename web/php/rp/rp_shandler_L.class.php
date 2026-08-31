<?

class rp_shandler_L {

	//получение результирующх данных от ресурсов
	//0L/rd!-ne
	static function get($name, $set = false, $bundle = false){

		//partName: $name|$part
		//[mb td $bundle as possible config of req: css_link, css_inline]


		//приведение установок $set = static::conf($set)
		if (prop($set, 'inline')) {
			$set['is_js_inline'] = true;
			$set['is_css_inline'] = true;
			unset($set['inline']);
		}

		$res = $html = static::tpl($name, $set, !$bundle);

		// bundle: результат как массив данных [html, js, css]
		if ($bundle) {
			$res = array(
				'html' => $html,
			);

			if (prop($set, 'is_js_inline')) {
				$res['js_inline'] = static::js_inline($name, $set, false);
			} else {
				$res['js_link'] = static::js_link($name, $set);
			}

			if (prop($set, 'is_css_inline')) {
				$res['css_inline'] = static::css_inline($name, $set, false);
			} else {
				$res['css_link'] = static::css_link($name, $set);
			}
		}
		//\bundle

		return $res;
	}


	//0 \mb-section
	static function tplEnv($name = true, $ctx = false){ //|tplInline|tplEnv|
		$tplCtx = array(
			//default values:
			'css' => null,
			'js' => null,
			'is_css_inline' => true,
			'is_js_inline' => true,
		);
		if (is_array($ctx)) {
			$tplCtx = array_replace($tplCtx, $ctx);
		}
		return static::tpl($name, $tplCtx);
	}

}