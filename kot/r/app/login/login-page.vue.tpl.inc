<?
$Self = _kot::self();
$nP = $Self::nc('page');

$Self::req_css('login');

//_kot::req_vue('ui', 'form/field', array(), 'ui-field');
$Self::req_vue('login-form');

$bgN = gt('bg', _proKot('bg-num'));

?>
<div wp100 hp100 class="<?=$nP?> bg-<?=$bgN?>">
    <div avh class="<?=$nP?>-form">

        <login-form></login-form>

    </div>
</div>