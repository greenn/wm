<?
$Self = _kot::self();
$_ctx = $Self::tempCtx(array(
	'nc' => '',
));
$nc = $_ctx['nc'];

?>
<? if (1) { ?>
    <pre no>opt: {{ opt }}</pre>
<? } ?>
<div r fxr fxw fxi="c"  fs12 class="<?=$nc?>" mb10>
    <div fxr fxi="c" mr20 v-for="(value, name) in opt">
		<?// :checked="o.checked" ?>
        <span>
            <input :id="`opt-${name}`" type="checkbox" v-model="opt[name]"  />
        </span>
        <label :for="`opt-${name}`">{{ name }}</label>
    </div>
</div>