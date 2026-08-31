<?
$error = false;
$sql_error = false;
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'fields' => '',
	'emu' => false,
));
$fields = $_ctx['fields'];
$emu = str2val($_ctx['emu']);
//d($fields, $emu);

$ntInfo = 'db-info';
$ntData = 'targets-list';
$wrInfo = array('table' => $ntData);



if (!isset($fields['date'])) {
	$fields['date'] = $Self::date_value();
}


if ($emu) {
	$nsEmuLastId = 'targets-list-last-id';
	if (!_s(true, $nsEmuLastId)) {
		_s($nsEmuLastId, $lastId = mc::item_get1_prop('last_id', $ntInfo, $wrInfo));
	}

	$newId = _s($nsEmuLastId) + 20;
	$fields['uid'] = $newId;

	$success = true;
	_s($nsEmuLastId, $newId);

} else {
	$lastId = mc::item_get1_prop('last_id', $ntInfo, $wrInfo);
	$newId = $lastId + 20;
	$fields['uid'] = $newId;

	$res1 = mc::item_add($ntData, $fields);

	$sql_error = mc::error();
	$sql_last = mc::last_sql(); //dbg

	$res2 = mc::item_update($ntInfo, array('last_id' => $newId), $wrInfo);
	$success = $res1 !== false && $res2 === true;
}




//dx($fields, mc::last_sql(), mc::error(), $res1, $res2);

return array(
	'new-item' => $Self::prepare_item_data($fields),
	'new-id' => $newId,
	'success' => $success,

	'sql_error' => $sql_error,
	'error' => $error || !!$sql_error,

	//dbg
	'res1' => @$res1,
	'res2' => @$res2,
	'sql_last' => @$sql_last,
);