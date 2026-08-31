<?
    $Self = _rw::name('tool-log');
    $nRB = $Self::nc('request-bar');

    //css::req('rw', 'tool-css', 'calc-vu/calc-vu.css.php');
?>
<section class="<?=$nRB?>" ref="bar" >

    <div class="<?=$nRB?>-w" :style="{ top: -shift + 'px' }">
        <div class="<?=$nRB?>-i" v-for="point in points" :title="point.title"></div>
    </div>

</section>