<? ob_start(); ?>
	<style type="text/css">
		.bWD-v1-embody {
			margin-left: 140px;
		}
	</style>

<? $css = ob_get_clean();
return array(
	//'img' => 'intro.png',
	'img' => 'about-us/roadmap.png',
	'embody' => $css.site_tpl('about-us', 'roadmap'),
	//'v' => 2
);