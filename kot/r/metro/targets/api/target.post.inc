<?
//API: create Target
_needphp('fq/str/str2val', 'str/endsWith', 'fq/hash');

$nsLast = 'metor-api-target-last-post';
$ntTpl = 'targets-tpl';

$response = array();
$error = false;
$sql_error = false;


$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'target' => '',
));
$target = $_ctx['target'];

$hash = qhash($target);
$sameHash = $hash === _s($nsLast);

$except_fields = array('id');
$fields = mc::item_pickFields($ntTpl, $target, $except_fields);
if (!$fields) return kot_api::response(array(
	'error' => 'Нет данных для таргетов',
	'fields' => $fields,
));


$Self::_prepare_db_target($fields);
/*
$dateTimeProps = array('from', 'to');
foreach ($dateTimeProps as $prop) {
	$date = prop($target, $prop);
	if ($date = prop($target, $prop)) {
		$dateTime = new DateTime($target[$prop]);
		$target[$prop] = $dateTime->format('Y-m-d H:i:s');
	}
}

foreach ($target as $prop => &$value) {
	if (endsWith($prop, '-fix')) {
		$value = str2val($value);
	}
}
*/


$id = $res = mc::item_add($ntTpl, $fields);
$fields['id'] = $id;

if ($res) _s($nsLast, $hash);


return kot_api::response_res($res, array(
	'target-id' => $id,
	'fields' => $fields,

	'ajax' => $Self::temp_last(),

	'dbg' => 'hash;hash=',
	'hash' => $hash,
	'hash=' => $sameHash,
));