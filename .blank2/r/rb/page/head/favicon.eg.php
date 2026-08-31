<?

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