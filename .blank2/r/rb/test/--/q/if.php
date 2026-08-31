<? include_once $_SERVER['DOCUMENT_ROOT'].'/web/iq.inc';

function f(){
	return false;
}

function t(){
	return true;
}

if ($res = f()) echo 10; else echo 20;
print '<hr />';

if (!$res = f()) echo 30; else echo 40;
print '<hr />';


if ($res = t()) echo 50; else echo 60;
print '<hr />';

if (!$res = t()) echo 70; else echo 80;
print '<hr />';


dx(
	$res = f() ? 10 : 20,
	!$res = f() ? 10 : 20,

	$res = t() ? 10 : 20,
	!$res = t() ? 10 : 20
);
