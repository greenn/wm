<?
$Self = _kot::self();
$Self::req_css('target-tpl');

$nT2 = $Self::nc('T2');

_kot::req_vue('ui', 'field', array(), 'ui-field');
?>
<span fxr fxi="b">
    <span class="-label" v-if="label">{{ label }}</span>
    <template v-if="valueFix">
        <b class="<?=$nT2?>-fix">
            <template v-if="type === 'datetime-local'">
                {{ formatDate(value, 'D.M.Y H:i') }}
            </template>
            <template v-else>
                {{ value || def }}
            </template>
        </b>
    </template>
    <template v-else>
        <ui-field :class="[nc]"
            :value="value || value0"
            :disabled="1"
            :type="type"
        ></ui-field>
    </template>
</span>