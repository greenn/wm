<?
_needphp('fq/arr/defaultsDeep');

_site::reg('page', array(
	'nc' => array(
		'base' => 'Pg'
	),
));

class site_page extends site {

	static function og($og){
		if ($og === true) {
			$og = array(
				'color' => '#ffffff',
				//'ms-color' => _css('main-gradient-bg'),
				'ms-color' => '#01569f',
				'title' => _pro('seo-share'),
				'image' => _i::hostUri('logo/logo-w.t.155x90.png'),
				'url' => domainUrl, //URL
			);
		}
		return $og;
	}

	static function favicon($favicon){ //ak faviconMaster
		if ($favicon === true || is_numeric($favicon)) {
			$vFavicon = is_numeric($favicon) ? $favicon : 1;
			$favicon = array(
				'imgSubDir' => "v{$vFavicon}",
				'data' => array( //by https://favicon.io/favicon-converter/
					'apple-touch-icon' => 'apple-touch-icon.png',
					'32' => 'favicon-32x32.png',
					'16' => 'favicon-16x16.png',
					//'android-chrome-192x192',
					//'android-chrome-512x512',
				)
			);
		}
		return $favicon;
	}

	static function webkit() {
		//here: подключение js/css библиотек на страницу
		return array(
			'jquery',
			'lodash',
			'animate-css',
		);
	}

}