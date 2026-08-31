<?
css::req(false, false, '.site-w { max-width: unset; }');

$n_F = site('footer', 'nc', '1');
css::req(false, false, ".$n_F-w { left: 12px; }");

return array(
	'img' => 'footer.png',
	'embody' => site_tpl('footer', 'footer-1'),
	#'css-fix' => 'left: -600px',
);