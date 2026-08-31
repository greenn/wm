<?
$Self = _rb::self();
$nPos = $Self::nc('pos');

//$Self::req_css('drozd');
$Self::req_css('drozd');
ob_start();
?>
<div pane fxr>
    <div cp @click="moveTargetStep(-1, -1)">↖️</div>
    <div cp @click="moveTargetStep(0, -1)">⬆️</div>
    <div cp @click="moveTargetStep(1, -1)">↗️</div>
    <div>
        <div fxn>
            <label>step</label>
            <input type="number" min="1" max="99" v-model="pos.step" w25 />
        </div>

    </div>
</div>
<div pane fxr>
    <div cp @click="moveTargetStep(-1, 0)">⬅️</div>
    <div cp @click="moveReset()">🔄</div>
    <div cp @click="moveTargetStep(1, 0)">➡️</div>
    <div>
        <div fxn>
            <input h12 :id="`pos-r-${name2}`" type="checkbox" v-model="pos.r" :disabled="pos.r_disabled" />
            <label cp :for="`pos-r-${name2}`">r</label>
        </div>
    </div>
</div>
<div pane fxr>
    <div cp @click="moveTargetStep(-1, 1)">↙️</div>
    <div cp @click="moveTargetStep(0, 1)">⬇️</div>
    <div cp @click="moveTargetStep(1, 1)">↘️</div>
    <div>
        <div fxn>
            <label>z</label>
            <input w45 type="number" v-model="pos.z"  />
        </div>
    </div>
</div>
<div fxr>
    <div mr5 @mousedown="dragTarget" :cg="pos.ds ? 'on' : ''" nos>⚛</div>
    <div>(</div>
    <div>{{ pos.y }}</div>
    <div>, </div>
    <div>{{ pos.x }}</div>
    <div>)</div>
</div>
<?
print rb_tpl('vue', 'provide/drozd/drozd-frame', array(
    'nc' => $nPos,
    'title' => 'pos',
    'content' => ob_get_clean(),
));