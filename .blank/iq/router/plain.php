<?#1.3.0

$Self = _rb::name('router');
$_ctx = $Self::tempCtx(array(
	'pid' => '',
));
$pid = $_ctx['pid'];

$pageTpl = _page($pid, 'page-tpl');

$html = rb('page-content', 'applyContent', $pageTpl);
//$html = rb('page-content', 'applyContentTpl', $pageTpl);
//d($html, $pageTpl, $html);

print is_string($html) ? $html : '';