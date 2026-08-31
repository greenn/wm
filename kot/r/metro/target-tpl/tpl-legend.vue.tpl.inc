<?
$Self = _kot::self();
$nL = $Self::nc('legend');
$Self::req_css('target-tpl');
?>
<?//sb sa ?>
<div fxr="sa" fxi="fs" class="<?=$nL?>">


    <div fxr class="<?=$nL?>-item" v-for="point in points">
        <div fxr fxi="b" r class="<?=$nL?>-eg">
            <input type="checkbox" :checked="point.checked">
            <span dash>—</span>
        </div>
        <div class="<?=$nL?>-descr" v-html="point.text"></div>
    </div>

</div>