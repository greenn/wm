<?
$Self = _rb::self();
$_ctx = $Self::tempCtx(array());
?>

<div>
    <div>button: {{$options.name}}</div>
    <button @click="click" :style="styleObject">
        <b v-if="pressed">+</b>
        <b v-else>-</b>
        <span v-text="pressed ? 1 : 0"></span>
        {{$parent.curCmptName}}
    </button>
</div>
