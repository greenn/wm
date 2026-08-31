<?
$Self = _kot::self();
$nT3 = $Self::nc('T3');
$nPSF = $Self::nc('P-SF'); //passes--station-freq
$Self::req_css('target-tpl');

//_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'field', array(), 'ui-field');

$Self::req_vue('tpl3/tpl3-field', array(), 'tpl3-field');
$Self::req_vue('tpl3/tpl3-stations', array(), 'tpl3-stations');
$Self::req_vue('tpl3/tpl3-interval', array(), 'tpl3-interval');

?>

<section fxr fxw fxi="b" class="<?=$nT3?> <?=$nPSF?>">

    <tpl3-field
        :label="'Количество'"
        :value="cfg['passes_min']"
        :valueFix="cfg['passes_min-fix']"
    ></tpl3-field>

    <span class="<?=$nT3?>-sep"></span>

    <tpl3-interval
        :value="cfg['interval']"
        <?//:from="cfg['from']"?>
        <?//:to="cfg['to']"?>
    ></tpl3-interval>


</section>
