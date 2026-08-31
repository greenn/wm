<?
$Self = _kot::self();

$_ctx = $Self::tempCtx(array(
	'ms' => 500
));
$ms = $_ctx['ms'];

usleep($ms * 1000);

return array(
	'delay' => $ms,
	'success' => true,
);