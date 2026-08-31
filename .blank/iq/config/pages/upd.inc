<?

$selfDir = dirname(__FILE__);

//$updCtx = include "$selfDir/upd/upd-1.data.inc";
//$updCtx = include "$selfDir/upd/upd-2.data.inc";
//$updCtx = include "$selfDir/upd/upd-3.data.inc";
//$updCtx = include "$selfDir/upd/upd-4.data.inc";
/*
if (time() > strtotime('2024-01-24 14:15:15')) {
	$updCtx = include "$selfDir/upd/upd-6.data.inc";
	$updCtx = include "$selfDir/upd/upd-6.data.inc";
} else {
	$updCtx = include "$selfDir/upd/upd-5.data.inc";
}
*/
//$updCtx = include "$selfDir/upd/upd-catalog.data.inc";

//$updCtx = include "$selfDir/upd/upd-6.data.inc";

if (0) $updCtx = rb('uc-upd', 'call', 'ctx/upd-base-d2.data', array(
	'start' => '2024-04-06 17:00',
	'until' => '2024-04-06 18:30',
	'until2' => '2024-04-06 21:22',
	//'until2' => true,
	//'until3' => '2024-04-06 15:15',

	//'until2' => '2024-04-06 14:02',
	//'until3' => '2024-04-06 14:08',
	'success' => array(
		'warn' => 2,
	),
));

if (!1) $updCtx = rb('uc-upd', 'call', 'ctx/upd-base.data', array(
	'start' => '2024-04-08 12:30',
	'until' => '2024-04-08 15:45',
	'success' => array(
		//'warn' => 0,
	),
));

$updCtx = rb('uc-upd', 'call', 'ctx/upd-base-d2.data', array(
	'start' => '2024-04-10 04:09',
	'until' => '2024-04-10 16:37',
	'until2' => '2024-04-10 21:09',
	//'until2' => true,
	//'until3' => '2024-04-06 15:15',

	//'until2' => '2024-04-06 14:02',
	//'until3' => '2024-04-06 14:08',
	'success' => array(
		//'warn' => 2,
	),
));

//$updCtx = rb('uc-upd', 'call', 'ctx/upd-1.data');
//dx($updCtx);

return array(
	'router' => 'plain',
	'page-tpl' => array('rb' ,'uc-upd', 'upd-page', $updCtx),
);