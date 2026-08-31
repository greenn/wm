<?
$Self = _kot::self();
$nT2 = $Self::nc('tpl2');
$nPSF = $Self::nc('P-SF'); //passes--station-freq
$Self::req_css('target-tpl');

//_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'field', array(), 'ui-field');
_kot::req_vue('ui', 'busy', array(), 'ui-busy');
$Self::req_vue('tpl2-field');

?>
<div>
    <section fxr fxw fxi="b" class="<?=$nT2?> <?=$nPSF?>">
        <span>Проходы более</span>
        <tpl2-field
            :value="cfg['passes_min']"
            :valueFix="cfg['passes_min-fix']"
            :nc="'-num2'"
        ></tpl2-field>

        <span>на станциях:</span>
        <div class="<?=$nPSF?>-stations">
            <ui-busy v-if="busy" :visible="true"></ui-busy>
            <template v-else-if="!cfg['station']">
                <b class="w-bld -red">- выбрать -</b>
            </template>
            <template v-else>
                <b v-for="station in cfg['station']" class="w-bld">
                    {{ getStationTitle(station) }}
                </b>
            </template>
        </div>

        <tpl2-field
            :valueFix="cfg['station-fix']"
            :value="cfg['station']"
            :value0="'- выбрать станцию -'"
            :def="'- любая -'"
            :type="'select'"
            :nc="'-station'"
            <?//:options=""?>
        ></tpl2-field>

        <span>в период от</span>
        <tpl2-field
            :value="cfg['from_preset']"
            :valueFix="cfg['from-fix']"
            :def="'- выбрать -'"
            :type="'select-time'"
            :nc="'-select-time'"
        ></tpl2-field>
        <span>до</span>
        <tpl2-field
            :value="cfg['to_preset']"
            :valueFix="cfg['to-fix']"
            :def="'- выбрать -'"
            :type="'select-time'"
            :nc="'-select-time'"
        ></tpl2-field>

    </section>

    <section fxr fxw fxi="b" class="<?=$nT2?>">
        <span>Проходы более</span>
        <?=$Self::tpl('tpl2-field', array('cfg' => 'passes_min', 'nc' => '-num2'))?>
        <span>на станции</span>
        <?=$Self::tpl('tpl2-field', array(
            'nc' => '-station',
            'cfg' => 'station',
            'type' => 'select',
            'options' => '',
            'def' => '- любая -',
            'value0' => '- выбрать станцию -',
        ))?>
        <span>в период от</span>
        <?//=$Self::tpl('tpl2-field', array('cfg' => 'from', 'type' => 'datetime-local', 'nc' => '-datetime'))?>
        <?=$Self::tpl('tpl2-field', array(
            'nc' => '-select-time',
            'cfg' => 'from_preset',
            'cfg-fix' => 'from-fix',
            'type' => 'select-time',
            'def' => '- выбрать -'
        ))?>
        <span>до</span>
        <?//=$Self::tpl('tpl2-field', array('cfg' => 'to', 'type' => 'datetime-local', 'nc' => '-datetime'))?>
        <?=$Self::tpl('tpl2-field', array(
            'nc' => '-select-time',
            'cfg' => 'to_preset',
            'cfg-fix' => 'to-fix',
            'type' => 'select-time',
            'def' => '- выбрать -'
        ))?>
    </section>
</div>