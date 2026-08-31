<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$t = true;
$f = false;

$s = 's';

if (0) dx(array(
	'$f + 0' => $f + 0,
	'$f + 1' => $f + 1,
	"$t + 's'" => $t,
	'$f + array()' => $f + array(),

), array(

));

d(
	$f + 0,
	$f + 1,
	$t + $s
	//$f + array(),
	//$f + array(1)
);

d(
	$t * 0,
	$t * 1,
	$t * 's',
	$t * array(),
	$t * array(1)
);