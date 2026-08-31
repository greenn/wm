<?
$Self = _rw::name('tool-log');
$nRB = $Self::nc('request-bar');

//css::req('rw', 'tool-css', 'calc-vu/calc-vu.css.php');
?>
<section class="<?=$nRB?>" ref="bar" >

	<? if (0) { ?>
        <div class="<?=$nRB?>-i" class="-filled"></div>
        <div class="<?=$nRB?>-i" class="-filled"></div>
        <div class="<?=$nRB?>-i" class="-filled"></div>
        <div class="<?=$nRB?>-i" class=""></div>
        <div class="<?=$nRB?>-i" class=""></div>
        <div class="<?=$nRB?>-i" class=""></div>
        <div class="<?=$nRB?>-i" class=""></div>
        <div class="<?=$nRB?>-i" class=""></div>
	<? } ?>

    <div class="<?=$nRB?>-i" v-for="point in points" :class="{ '-filled': point.isFilled }"></div>


</section>