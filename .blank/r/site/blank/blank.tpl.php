<?
$Self = _site::self();
$n = $Self::nc();

//$Self::req_css('blank');
//$Self::req_js('blank');

$_ctx = $Self::tempCtx(array('var' => ''));
$var = $_ctx['var'];
?>

<div class="<?=$n?>">
    <div indent="<?=$n?>-before"></div>
    <i title="<?=$Self::cfg('className')?>"><?=$Self::cfg('rName')?> : <?=basename(__FILE__, 'tpl.php')?></i>
    <div indent="<?=$n?>-after"></div>
</div>