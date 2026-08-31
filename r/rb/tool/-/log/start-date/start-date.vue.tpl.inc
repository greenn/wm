<?
$Self = _rw::name('tool-log');
$nSD = $Self::nc('start-date');
?>
<div fxr="c" class="<?=$nSD?>">
    <div>Start date</div>

    <div><input
        type="datetime-local"
        <?//v-model="startTime"?>
        v-model="field.value"
    ></div>

    <div>
        <button @click="setDate">set</button>
    </div>
</div>