<?

//Thin 100 / Extra-light 200 / Light 300 / Regular 400 / Medium 500
//Semi-bold 600 / Bold 700 / Extra-bold 800 / Black 900
$ffs = array(
	'M' => array('Fira Code', 'wght' => '300,400,500,700'),
	'SS' => array('Fira Sans', 'wght' => '300,400,500,700'),
	'I' => array('Material Icons', 'wght' => ''),
	'IO' => array('Material Symbols Outlined', 'wght' => ''),
);

//$n_PT = site('page', 'nc', 'text'); //page-text


//q01
$_FS = array( //$fsData
	'n'     => array('.ft-min', 11, 400),
	'sm'     => array('.ft-small', 14, 400),
	//'button'     => array('.ft-button', 14, 500),
	'menu'    => array('.ft-menu', 16, 400),
	't'     => array('.ft-text', 16, 500),
	'mT'     => array('.ft-msg-text', 17, 400),
	'm'     => array('.ft-middle', 18, 500),
	'mH'     => array('.ft-msg-head', 21, 400),
	//'s'     => array('.ft-section', 29, 400),
	//'p'     => array('.ft-page', 36, 500),
	'h'     => array('.ft-high', 20, 500),
	//'hg'    => array('.ft-huge', 78, 900, 'fh' => 96 /*mn 92*/),
	//'l-hg'   => array('.ft-logo.-hg', 75, 'ls' => -3),
);


return array(
	'data' => array(
		'ffs' => $ffs,
		'f0' => 'sans-serif',
		#~ 'f1' => 'Montserrat',
	),

	//используется после уже линковки (_css::prepare_set)
	'extend' => array(
		'fs_' => $_FS
	)
);