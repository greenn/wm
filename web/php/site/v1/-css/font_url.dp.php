<?php
/*


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">



*/
/*
    ==
		inc/css/font_use.php
			inc/css/font_use.eg-1.php
			inc/css/font_use.eg-2.php

*/


#   #   #   #   #   #   #   #   #   #   #   #
$ff0 = 'sans-serif';

$fs1_req = join(',', array(
	'300',
	//'300i',
	'400',
	//'400i',
	'600',
	//'600i',
	'700',
	//'700i',
	//'800',
	//'800i',
));

$fs2_req = join(',', array(
	'400',
	//'400i',
	//'700',
	//'700i',
));
//== fonts-opts [oo site/man/site.help::--fonts]
$fo_hinted = true ? 'on' : 'off';
$fo_vfix = !true ? 'on' : 'off';
$fo_local = !true ? 'on' : 'off';
$fo_display = array('auto', 'block', 'swap', 'fallback', 'optional', /*5*/'')[2];

//с любой страницы можно передать сюда изменения
if (gt_has('fo_hinted')) $fo_hinted = gt('fo_hinted');
if (gt_has('fo_vfix')) $fo_vfix = gt('fo_vfix');
if (gt_has('fo_local')) $fo_local = gt('fo_local');
if (gt_has('fo_display')) $fo_display = gt('fo_display');
$hostUrl = (!true && 'dbg') ? hostUrl : '';

$ffs = array(
	//'https://fonts.google.com/selection?query=Arvo&selection.family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&selection.subset=latin-ext'
	//https://fonts.google.com/selection?query=Arvo&selection.family=Arvo:400,400i,700,700i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&selection.subset=latin-ext

	'1' => array('Open Sans',
		//'https://fonts.googleapis.com/css?family=Open+Sans&display=swap',
		//'https://fonts.googleapis.com/css?family=Open+Sans:'.$fs1_req.'&display=swap&subset=latin-ext',
		qv($hostUrl."/site/css/fonts/open_sans.css.php?filter=$fs1_req&display=$fo_display&hinted=$fo_hinted&vfix=$fo_vfix&local=$fo_local")//&subset=latin-ext",
	),

	'2' => array('Arvo',
		//'https://fonts.googleapis.com/css?family=Arvo:'.$fs2_req.'&display=swap&subset=latin-ext'
		//"/site/css/fonts/arvo.css.php?filter=$fs2_req&display=swap",
		qv($hostUrl."/site/css/fonts/arvo.css.php?filter=$fs2_req&display=$fo_display&hinted=$fo_hinted&vfix=$fo_vfix&local=$fo_local"),
	),
);


