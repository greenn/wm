<?
//_needphp('parser/strTabMenuParser.class');

$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'mock' => '',
));

$mock = $_ctx['mock'];
$type = $mock ? "-$mock" : ''; //ak dataType

//$data = api_kot('side-menu/v0/list.data');
$data = include_once $Self::path($Self::relDir("list{$type}.data.php"));
//dx($data);

return array(
	'list' => $data,
);