<?
$Self = _kot::self();
$_ctx = $Self::tempCtx(array(
	'nc' => '',
));
$nc = $_ctx['nc'];
?>
<div r class="<?=$nc?>" mb10>
    <div fxr fxi="c" mr20 v-for="(item, name) in set">
        <label wmp12 mr5 :title="item.title">{{ item.label || name }}:</label>

        <div v-if="item.select" mr3>
            <ui-button s-button small @click="updateSelect(name)">
                <icon-mi anff :class="{ 'spin-rev': busy[name] }">sync</icon-mi>
            </ui-button>
        </div>

        <div wp20 mr5 v-if="item.select">
            <select wp100 v-model="item.value">
                <option v-for="option in item.select"
                        :value="option"
                >{{ option }}</option>
            </select>
        </div>

        <div wp20 mr5 v-if="!item.lock"><input p0 wp100 v-model="item.value" :name="`set-${name}`" /></div>

        <div wp20 ml5 v-if="item.cmd" v-for="cmd in item.cmd">
            <ui-button b-button small @click="cmd.click" :disabled="!item.value || !item.select.includes(item.value)">{{ cmd.text }}</ui-button>
        </div>


    </div>
</div>