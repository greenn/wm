<?//API: update Target-Tpl

_needphp('fq/str/str2val', 'str/endsWith', 'fq/hash');

$nsLast = 'metor-api-target-last-post';
$ntTpl = 'targets-tpl';

$response = array();
$error = false;
$sql_error = false;

$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'id' => '',
	'target' => '',
));
$id = $_ctx['id'];
$target = $_ctx['target'];

$targetOrig = $target;
$Self::_prepare_db_target($target, $target['name']);
//dx($target, $targetOrig);

$except_fields = array('id');
$update = mc::item_pickFields($ntTpl, $target, $except_fields);
//dx($target, $update, array_diff_assoc($target, $update));

$success = mc::item_update($ntTpl, $update, array('id' => $id)); //#Q7
$sql_error = mc::error();
$sql_last = mc::last_sql(); //dbg



return kot_api::response_res($success, array(
	'ajax' => $ctx = $Self::temp_last(),

	'update' => $update,
	'dbg-diff' => array_diff_assoc($target, $update), //невошедшее в обновление
	'dbg' => array(
		//'$target' => $target,
		//'$update' => $update,
	)
));