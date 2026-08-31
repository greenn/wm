<?
$Self = _kot::self();
$n = $Self::nc();
$Self::req_css('blank');
$_ctx = $Self::tempCtx(array('icon' => '☺'));
$icon = $_ctx['icon'];
?>

<div class="<?=$n?>">
    <div indent="<?=$n?>-begin"></div>
    <i><?=$Self::cfg('className')?></i>
    <div indent="<?=$n?>-end"></div>
</div>