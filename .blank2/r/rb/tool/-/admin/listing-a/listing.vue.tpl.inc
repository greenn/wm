<?
$Self = _rw::name('tool-admin');
$nL = $Self::nc('listing');
$nLC = $Self::nc('listing-cmd');
$_ctx = $Self::tempCtx(array(
	'id' => $Self::nc()
));
$id = $_ctx['id'];

rb('vue', 'req', 's-icon');
rb('page', 'req_css', 'css/reset');

?>
<div class="<?=$nL?>">
    <div v-for="(item, index) in list">
        <s-icon oi png="pencil" @click="$root.link('edit', item.id)" class="<?=$nLC?> -edit" rst="btn"></s-icon>
        <span>&nbsp;</span>
        <span>{{ item.id }}</span>
        <span>. </span>
        <span>{{ item.value }}</span>


    </div>

</div>