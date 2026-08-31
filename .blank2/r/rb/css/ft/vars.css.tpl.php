<?
    $Self = _rb::self();
    $_ctx = $Self::tempCtx(array(
        'class' => '_css',
    ));
    $class = $_ctx['class'];
?>
<?
    $list = $class::$db;
    //dx($list);
?>
:root {
    <? foreach ($list as $name => $value ) {
		$name = _cssvarname($name);
    ?>
        <? if(is_array($value)) { ?>

        <? } else { ?>
            <?=$name?>: <?=$value?>;
        <? }?>
    <? } ?>
}