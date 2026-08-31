<?
$Self = _kot::self();
$n = $Self::nc();

//_kot::req_vue('ui', 'form/field', array(), 'ui-field');
//$Self::req_vue('form/field', array(), 'ui-field');

$Self::req_css('msg-pane');
?>
<lay-section fg tight class="<?=$n?> ft-kot-msg-pane" tabindex="0" @keydown="handleKeydown">

    <div fxr class="<?=$n?>-cmd">

        <div fxr fxi="c" mr20 v-for="(value, name) in opt">
			<?// :checked="o.checked" ?>
            <span>
                <input :id="`opt-${name}`" type="checkbox" v-model="opt[name]"  />
            </span>
            <label :for="`opt-${name}`">{{ name }}</label>
        </div>

        <div fg txr>
            <ui-button small bu-button title="Reset" @click="resetStatus">
                reset
            </ui-button>
        </div>
    </div>

    <div>
        <b>status ({{ status_index }})</b>
    </div>
    <div pv5>
        <button mr3 mb3 pv2 ph3 fs10 fvcp v-for="(status, index) in status_list"
            @click="status_index = index"
            :fw9="status_index === index ? '' : null"
        >{{ index }}</button>
    </div>

    <div b>{{ status_list[status_index]?.ref }}</div>
    <pre p3 osx
         v-show="status_list.length"
    >{{ status_list[status_index]?.value }}</pre>

</lay-section>