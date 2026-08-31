<?
$Self = _kot::self();
$n = $Self::nc();

//_rb::req_css('lay', 'flex');
//_rb::req_css('page', 'css/aq');
$Self::req_css('blank');

//$_tx = $Self::lang();
//$_ctx = $Self::tempCtx(array('icon' => '☺'));
//$icon = $_ctx['icon'];
?>

<div class="<?=$n?>">
    <div indent="<?=$n?>-begin"></div>
    <i><?=$Self::cfg('className')?></i>
    <div indent="<?=$n?>-end"></div>
</div>