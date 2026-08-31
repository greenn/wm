<?
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'by' => 'addr'
));
$prop = $_ctx['by'];


$data = api_kot('side-menu/menu');
$list = strTabMenuParser::convertToListBy($prop, $data['list']);

return array(
	'by' => $prop,
	'list' => $list,
);