<?
$Self = _lay::self();
//$nI = $Self::nc('img');


$_ctx = $Self::tempCtx(array(
    'uri' => '',
    'pic' => '',
));

$uri = $_ctx['uri'];
if (!$uri) {
    $uri = _i::uri($_ctx['pic']);
}
?>
<img src="<?=$uri?>" />