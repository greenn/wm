<?#0.1.1
_needphp('set');
/*
	class-index: _0 | -0
	class-num-index: _1 | -1
	class-index-pattern:

	oo web/inc/qhtml/tag.php
*/
function tag_wrap($tag, $list, $set = false) {
	if (is_string($set)) $set = array('attr' => $set);
	$set = set($set); //zf

	if (!is_array($list)) $list = array($list);

	foreach ($list as $index => $item) {

		$_attr = '';
		if ($set->attr) $_attr = ' '.$set->attr;

		$list[$index] = "<$tag$_attr>$item</$tag>";
	}

	return $list;
}

function join_tag_wrap($glue/*, args for tag_wrap*/){
	$data = call_user_func_array('tag_wrap', array_slice(func_get_args(), 1));
	return join($glue, $data);
}