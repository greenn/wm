<? ob_start(); ?>

	<?=site_tpl('header', 'v0/header')?>
	<?=site_tpl('company', 'titul')?>

<? $embody = ob_get_clean();

return array(
	//'img' => 'intro.png',
	'img' => 'company.jpg',
	//'embody' => site_vtpl('header', array('header', 1)),
	//'embody' => site_tpl('header', 'v0/header'),
	'embody' => $embody
	//'v' => 2
);