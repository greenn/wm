<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nMF = $Self::nc('M-F'); //tpl-message--feedback
$Self::req_css('target-tpl');

$Self::req_vue('tpl2/tpl2-interval', array(), 'tpl2-interval');
?>
<section class="<?=$nT2?> -pt <?=$nMF?>">

	<?=$Self::tpl('vue-tpl2-forecast')?>

    <div fxr fxi="b">
        <span class="-pr">Количество сообщений:</span>

        <tpl2-field
                :label="'от'"
                :value="cfg['numFrom']"
                :valueFix="true"
                :nc="'-num2'"
        ></tpl2-field>

        <span class="<?=$nT2?>-sep"></span>

        <tpl2-field
                :label="'до'"
                :value="cfg['numTo']"
                :valueFix="true"
                :nc="'-num2'"
        ></tpl2-field>
    </div>

    <tpl2-interval
        :value="cfg['interval']"
        <?//:from="cfg['from']"?>
        <?//:to="cfg['to']"?>
    ></tpl2-interval>

</section>