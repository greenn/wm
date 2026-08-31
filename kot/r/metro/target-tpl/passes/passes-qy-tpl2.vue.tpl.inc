<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nPSF = $Self::nc('P-SF'); //passes--station-freq
$Self::req_css('target-tpl');

//_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'field', array(), 'ui-field');

$Self::req_vue('tpl2/tpl2-field', array(), 'tpl2-field');
$Self::req_vue('tpl2/tpl2-stations', array(), 'tpl2-stations');
$Self::req_vue('tpl2/tpl2-interval', array(), 'tpl2-interval');

?>
<section  class="<?=$nT2?> -pt <?=$nPSF?>">
    <?=$Self::tpl('vue-tpl2-forecast')?>

    <div fxr fxw fxi="b">
        <tpl2-field
            :label="'Количество'"
            :value="cfg['qy']"
            :valueFix="cfg['qy-fix']"
            :nc="'-num2'"
        ></tpl2-field>

        <span class="<?=$nT2?>-sep"></span>

        <tpl2-interval
            :value="cfg['interval']"
            <?//:from="cfg['from']"?>
            <?//:to="cfg['to']"?>
        ></tpl2-interval>
    </div>
</section>