<?
//js::css(1, false, false, ob_get_clean());
css::req(false, false, <<<css
.site-w {
    max-width: unset;
}
css
);
return array(
	//'img' => 'intro.png',
	'img' => 'header-3.png',
	//'embody' => site_vtpl('header', array('header', 1)),
	//'embody' => site_tpl('header', 'v0/header'),
	'embody' => site_tpl('header', 'header'),
	#'css-fix' => 'left: -600px',
	//'v' => '1b'
);