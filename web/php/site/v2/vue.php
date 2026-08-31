<?#0.2.1
_needphp(
	'site/v2/r/rp.class'
);

/*
	вставка vue тэга rp ресурса с добавление скриптов (tpl, js) в head
	eg

*/
function vue_tpl($vueCtx, $rName, $tplName = true, $tplCtx = true){
	if (is_string($vueCtx)) $vueCtx = array('id' => $vueCtx, 'name' => $vueCtx);
	if ($tplName === true) $tplName = $vueCtx['name'];
	return rb('vue', 'insert', $vueCtx, $rName, $tplName, $tplCtx);
}