<?

//oo iq/php/css.class.php:570

//Thin 100 / Extra-light 200 / Light 300
// Regular 400 / Medium 500 /Semi-bold 600
// Bold 700 / Extra-bold 800 / Black 900

//S - serif / с засечками
//SS - sans-serif / без засечек
//K - cursive

$ffs = array();

$ffs['PTS'] = array('PT Serif', 'wght' => '400,400i,600,800', 'generic' => 'serif');
$ffs['1'] = $ffs['S']  = $ffs['PTS'];

//q01
$_FS = array( //$fsData
	't' => array('.ft-text', 16, 500),
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