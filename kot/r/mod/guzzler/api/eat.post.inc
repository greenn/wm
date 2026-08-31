<?
_needphp('json');
_needphp('fq/str/str2val');
_needphp('file/move_file');

$Self = _kmod::self();

$_ctx = $Self::tempCtx(array(
	'dish' => 'json', //handler
	'cutlery' => '',
	'food' => '',
	'spice' => array(), //set
	'seasoning' => array(), //opt
	'ingredients' => array(), //prm

	'mock' => '',
));
if ($mock = $_ctx['mock']) {
	include $Self::path("mock/$mock.php");
}

//dx($mock, $_ctx, @$data);

$food = $_ctx['food'];
$food0 = $food; //фото еды

$opt = str2valDeep($_ctx['seasoning']);
$set = $_ctx['ingredients'];
$prm = $_ctx['spice'];

$status = array();
$result = array();

$dishPath = $Self::path("api/dish/{$_ctx['dish']}.php");

//dx($opt, $set, $prm);


if (is_file($dishPath)) {
	include $dishPath;
}


return kmod_api::response($result + array(
	'status' => $status,

	'post-set' => $set,
	'post-prm' => $prm,
	'post-opt' => $opt,
	//'food' => $food,
));