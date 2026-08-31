<?
$Self = _kot::self();
$n = $Self::nc();

$Self::req_css('side-pane');

_kot::req_vue('side-menu');

?>

<div class="<?=$n?>">
	<?//=kot('app', 'fake', 'menu-begin')?>
    <side-menu :list="list"></side-menu>
	<?//=kot('app', 'fake', 'menu-end')?>
</div>