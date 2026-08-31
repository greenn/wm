<?
$Self = _kot::self();
$nCN = $Self::nc('CN'); //clear-newline

$Self::req_css('clear-rn');

_kot::req_vue('ui', 'content-section');
_kot::req_vue('ui', 'checkbox', array(), 'ui-checkbox');

?>
<div class="<?=$nCN?>">


    <content-section input :icon="'input'" :title="'Input'" :toggler="false" :open="true">

            <div fxr>
                <?//                checkbox                ?>
                <span>
                    <label for="opt-tiret">дефисы ['—', '−', '-']</label>
                    <input id="opt-tiret" v-model="opt['tiret']" type="checkbox">
                </span>
	            <? if (!1) { ?>
		            <? if (!1) { ?><pre>tiret: {{ opt['tiret'] }}</pre><? } ?>
                    <ui-checkbox :label="'-'" v-model:value="opt['tiret']" ></ui-checkbox>
	            <? } ?>
	            <?//                /checkbox                ?>

                <span ml20>
                    <label for="opt-ol">OL</label>
                    <input id="opt-ol" v-model="opt['ol']" type="checkbox">
                </span>

            </div>


            <div area-w><textarea area v-model="input"></textarea></div>

    </content-section>

    <content-section output :icon="'output'" :title="'Output'" :toggler="false" :open="true">

        <div r area-w>

            <textarea area _disabled
                  ref="output"
                  v-html="output"
                  @click="onOutputClick"
            ></textarea>

            <div a="t" note="success" v-html="output_note"></div>
        </div>

    </content-section>

</div>