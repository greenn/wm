<?
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	//'path' => ''
));
//$path = $_ctx['path'];

$list = include 'data/menu.data.inc';
//dx($list);

return array(
	'list' => $list,
);