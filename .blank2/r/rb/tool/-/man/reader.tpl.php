<?

$self_nc = 'tool-man';
$Self = _rw::name($self_nc);
$_ctx = $Self::tempCtx(array(
	'sd' => ''
));
$sd = $_ctx['sd'];

$nR = $Self::nc('reader');

_rb::req_css('lay', 'flex');

css::req('rw', $self_nc, 'css/ui.css.php');
js::req('rw', $self_nc, 'reader.js.php');

//rb('vue', 'req', 's-toggle');

vue::req('rw', $self_nc, 'listing-m/listing', false, 'listing-m');
vue::req('rw', $self_nc, 'view-m/view', false, 'view-m');
//css::req('rw', $self_nc, 'listing/listing.css.php');

?>
<?//=kint_source()?>
<div fxr id="man" class="<?=$nR?>">
    <div lay="listing" class="<?=$nR?>-listing">
        <listing-m sd="<?=$sd?>"></listing-m>
    </div>
    <div lay="form" class="<?=$nR?>-view">
        <view-m></view-m>
    </div>
</div>