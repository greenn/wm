<?
$Self = _site::self();
$n = $Self::nc();
$Self::req_css('page');

$_ctx = $Self::tempCtx(array(

));
//d($_ctx);
?>
<div indent="<?=$n?>-start"></div>
<??>
<div class="<?=$n?> site-ww" mqr="1275" mqrk="bg-page">
    <div class="site-w site-p">
		<?=site_tpl('header', 'header')?>
    </div>

	<?=site_tpl('header', 'bg-ribbon')?>

    <div class="bg-main">
		<?=site_tpl('page-content', 'page-content', $_ctx)?>

		<?=site_tpl('page-content', 'footer')?>
    </div>
</div>
<div indent="<?=$n?>-end"></div>
