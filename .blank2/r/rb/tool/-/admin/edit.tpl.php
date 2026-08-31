<?

$self_nc = 'tool-admin';
$Self = _rw::name($self_nc);
$_ctx = $Self::tempCtx(array(
	'sd' => ''
));
$sd = $_ctx['sd'];

$nE = $Self::nc('edit');

_rb::req_css('lay', 'flex');
_rb::req_css('page', 'css/aq');


css::req('rw', $self_nc, 'css/admin.css.php');
css::req('rw', $self_nc, 'css/edit.css.php');
js::req('rw', $self_nc, 'edit.js.php');

//js::req('rw', $self_nc, 'api/sd.api.js.php');

//rb('vue', 'req', 's-toggle');

vue::req('rw', $self_nc, 'listing-a/listing', false, 'listing-a');
vue::req('rw', $self_nc, 'form-a/form', false, 'form-a');
//css::req('rw', $self_nc, 'listing/listing.css.php');

//rb('vue', 'req', 's-msg');

?>
<?//=kint_source()?>
<div id="app-edit" class="<?=$nE?>">

    <h4 tc>table: <b><?=$sd?></b></h4>
    <nav tc>
        <button @click="link('')">titul</button>
        <button @click="reloadPage">F5</button>
        <a href="#/add">add</a>
        <button @click="link('edit/1')">edit 1</button>
        <button @click="link('edit/2')">edit 2</button>
        <button @click="linkBack()">linkBack</button>
    </nav>

    <section fxr="se">
        <div pane="listing" class="<?=$nE?>-listing" o="2d">
            <div>
                <s-button @click="link('add')">add</s-button>
            </div>

            <listing-a sd="<?=$sd?>"></listing-a>
        </div>
        <div pane="side" o="2d">
            <div pane="msg" v-if="msg" v-html="msg">
                <? //<s-msg reg="msg"></s-msg> ?>
            </div>
            <hr />
            <div pane="form">
                <form-a sd="<?=$sd?>"
                    @create="onAdd($event)"
                    @update="onEdit($event)"
                    @remove="onDelete($event)"
                ></form-a>
            </div>
        </div>
    </section>
</div>