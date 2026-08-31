<?
$Self = _kmod::self();
$nM = $Self::nc('main');
$Self::req_css('guzzler');

_kot::req_vue('ui', 'button', array(), 'ui-button');
//$Self::req_vue('item', array(), 'blank-item');
?>
<div class="<?=$nM?>">
    <pre no>prm: {{ prm }}</pre>
    <pre no>opt: {{ opt }}</pre>

	<?//                    opt / seasoning                   ?>

    <div r fxr fxw fxi="c"  fs12 class="<?=$nM?>-cmd" mb10>
        <div fxr fxi="c" mr20 v-for="(value, name) in opt">
            <?// :checked="o.checked" ?>
            <span>
                <input :id="`opt-${name}`" type="checkbox" v-model="opt[name]"  />
            </span>
            <label :for="`opt-${name}`">{{ name }}</label>
        </div>
    </div>

    <?//                    set / ingredients                   ?>
    <div r class="<?=$nM?>-cmd" mb10>
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


	<?//                    cmd                                ?>

    <div r fxr="c" class="<?=$nM?>-cmd" mb10>

        <span <?//fg txc?>>
            <ui-button bu-button @click="eat">
                eat
            </ui-button>
        </span>


    </div>

    <div r class="<?=$nM?>-form">
        <?/*<div al class="<?=$nM?>-busy" v-if="busy" :dblclick="busy = false"></div>*/?>



        <div fxr fxw mb7>

            <ui-button mr2 small b-button @click="prmDeleteLast">
                <icon-mi>delete</icon-mi>
            </ui-button>

            <ui-button mr2 small b-button @click="prmAdd">
                <icon-mi>add</icon-mi>
            </ui-button>
            <span mr3></span>

			<?//                    prm / spice                   ?>

            <div fxr wp28 mr10 v-for="p in prm">
                <input type="checkbox" v-model="p.use"  />
                <label wp40><input p0 wp100 v-model="p.name" /></label>
                <span>:</span>
                <div wp60 mr2><input p0 wp100 v-model="p.value" /></div>
                <ui-button no ml5 mr6 small s-button title="запомнить" @click="false">
                    <icon-m>keep</icon-m>
                </ui-button>
            </div>




        </div>
        <div class="<?=$nM?>-textarea">
            <textarea v-model="textarea" @input="onInput"></textarea>
        </div>
    </div>

</div>