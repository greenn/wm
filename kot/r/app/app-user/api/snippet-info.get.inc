<?
$Self = _kot::self();

$uid = 977;
$dataPath = $Self::path("api/data/$uid.data.php");
//dx(is_file($dataPath), $dataPath);

if (is_file($dataPath)) {
	$data = include_once $Self::path("api/data/$uid.data.php");
} else {
	$uid = 700;
	$data = include_once $Self::path("api/data/$uid.data.php");
}

$data['ava-pic-src'] = kot_i::uri("user/ava/$uid/{$data['ava-pic']}");

return kot_api::response(array(
	'info' => $data
));