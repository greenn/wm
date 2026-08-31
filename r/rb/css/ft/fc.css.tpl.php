<?

$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
    'class' => '_css',
));
$class = $_ctx['class'];


$list = $class::$db;

$regex = '/^c(\d|[A-Z])/';
$cList = array_filter($list, function ($key) use ($regex) {
    return preg_match($regex, $key);
}, ARRAY_FILTER_USE_KEY);
//dx0($cList);
?>
<? foreach ($cList as $cls => $val) {
    $clsName = strtolower(substr($cls, 1)); //отсекаем "c"
    $cls1 = "c-$clsName";
    $cls2 = "-$cls";
?>
    <? foreach (array($cls1, $cls2) as $nc) { ?>
        .<?=$nc?>,
        .<?=$nc?>_,
        .<?=$nc?>_ *,
        .<?=$nc?>_ *[class*="ft-"],
        *[class*="ft-"].<?=$nc?>,
        *[class*="ft-"] .<?=$nc?>,
        *[class*="ft-"].<?=$nc?>_,
        *[class*="ft-"].<?=$nc?>_ *,
        *[class*="ft-"] .<?=$nc?>_,
        *[class*="ft-"] .<?=$nc?>_ *,
    <? } ?>
    [fc<?=$clsName?>],
    [fc="<?=$cls?>"] {
        color: <?=$val?>;
    }
<? } ?>

<? foreach (array(
    'white', 'black'
) as $prop) {
    $cls1 = "c-$prop";
    $cls2 = "-$prop";
    $val = $class($prop);
?>
    <? foreach (array($cls1, $cls2) as $nc) { ?>
        .<?=$nc?>,
        .<?=$nc?>_,
        .<?=$nc?>_ *,
        .<?=$nc?>_ *[class*="ft-"],
        *[class*="ft-"].<?=$nc?>,
        *[class*="ft-"] .<?=$nc?>,
        *[class*="ft-"].<?=$nc?>_,
        *[class*="ft-"].<?=$nc?>_ *,
        *[class*="ft-"] .<?=$nc?>_,
        *[class*="ft-"] .<?=$nc?>_ *,
    <? } ?>
    [fc<?=$cls2?>],
    [fc="<?=$prop?>"] {
        color: <?=$val?>;
    }
<? } ?>

