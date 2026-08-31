<?
$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
    'method' => '_css',
));
$method = $_ctx['method'];

$trq = $method('trq1');
$tr = $method('tr0');

$ns_FS = array();
foreach ($method('fs_') as $id => $set) {
    $ns_FS []= $set[0];
}

?>
<? foreach (array_merge($ns_FS, array(
    '.ft-menu-top',
    '.ft-link',
    '.ftq',
    '[class*="ft-"]',
)) as $sr) { ?>
<?=$sr?> {
    <?=pcss('transition', array(
        "font-size $trq",
        "line-height $trq",
        "letter-spacing $trq",
        "color $tr",
        //"font-weight $tr", //не работает
        "background-position $tr",
    ))?>
}
<? } ?>