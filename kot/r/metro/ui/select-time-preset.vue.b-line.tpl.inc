<?
$Self = _kot::self();
$nSTP = $Self::nc('STP'); //select-time-preset
$Self::req_css('form');
$Self::req_vue('select', array(), 'ui-select');
?>

    <div fxc fxi="b" class="<?=$nSTP?>">

        <div fx fg>
            <ui-select
                :label="label || 'Дата'"
                :options="options"
                :busy="busy"
                :value="value"
                :checkbox="checkbox"
                <?//oo iq/test/js/vue/vmodel/tt6/index.php - off man?>
                @update:value="$emit('update:value', $event)"
                @update:checkbox="$emit('update:checkbox', $event)"
            ></ui-select>
        </div>

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
