<?
$Self = _lay::self();
$n = $Self::nc();

//_rb::req_css('lay', 'flex');
//_rb::req_css('page', 'css/aq');
$Self::req_css('blank');

//$_tx = $Self::lang();
//$_ctx = $Self::tempCtx(array('icon' => '☺'));
//$icon = $_ctx['icon'];
?>

<div class="<?=$n?>">
	<?=$Self::lang('h1')?>
    <i><?=$Self::cfg('className')?></i>
</div>