<?
$Self = _site::self();

$_ctx = $Self::tempCtx(array());

print site_tpl('page', 'content-wrapper', array(
	'content-title' => 'Страница в Разработке',

	'content' => site_tpl('page', 'content-item', array(
		'content' => $Self::tpl('content-text', $_ctx)
	)),
));