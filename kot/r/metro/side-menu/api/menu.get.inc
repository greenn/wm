<?
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	//'path' => ''
));
//$path = $_ctx['path'];

$list = include 'menu.data.inc';

return array(
	'list' => $list,
);