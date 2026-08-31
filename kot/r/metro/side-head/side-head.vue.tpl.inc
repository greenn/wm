<?
$Self = _kot::self();
$n = $Self::nc();
$Self::req_css('side-head');
?>

<div r t class="<?=$n?>">
	<a b @click.prevent="linkTitul" title="На главную">
        <?=kot('app', 'fake', 'side-head-2')?>
    </a>
    <div a="t" class="<?=$n?>-toggle" @click="toggleButton">
        <?//=rb('wd', 'fake_src', '/kot/src/fake/side-head-toggle.png')?>
        <?=kot('app', 'fake', 'side-head-toggle')?>
    </div>
</div>