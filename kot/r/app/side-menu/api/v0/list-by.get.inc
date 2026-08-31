<?
_needphp('parser/strTabMenuParser.class');

$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'by' => 'addr'
));
$prop = $_ctx['by'];


//$data = api_kot('side-menu/v0/list'); $data['list']
$data = kot_api::get_prop('list', 'side-menu/v0/list');

$list = strTabMenuParser::convertToListBy($prop, $data);

return array(
	'by' => $prop,
	'list' => $list,
);