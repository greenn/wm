<?
$Self = _kot::self();
$nSTP = $Self::nc('STP'); //select-time-preset
$Self::req_css('form');
$Self::req_vue('select', array(), 'ui-select');
?>
<div class="<?=$nSTP?>" :class="{ '-disabled': disabled }">

    <ui-select
        ref="select"
        :label="label || 'Дата'"
        :options="options"
        :busy="busy"
        :hideBusy="true"
        :value="value"
        :checkbox="checkbox"
        :disabled="disabled"
        <?//oo iq/test/js/vue/vmodel/tt6/index.php - off man?>
        @update:value="$emit('update:value', $event)"
        @update:checkbox="$emit('update:checkbox', $event)"
    ></ui-select>

    <div class="<?=$nSTP?>-dates" v-if="dates && 0">
        <span class="-first">пример: с <b>{{ from }}</b></span>
        <span class="-last">по <b>{{ to }}</b></span>
    </div>

    <div fxr fxi="b" v-if="datefields" class="<?=$nSTP?>-datefields">
        <ui-field
            :label="'от'"
            :type="dateType"
            :value="from"
            :disabled="1"
            <?//@input?>
        ></ui-field>

        <ui-field
            :label="'до'"
            :type="dateType"
            :value="to"
            :disabled="1"
        ></ui-field>
    </div>
</div>