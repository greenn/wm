<?
$Self = _site::self();
$nIo = $Self::nc('Io');

$Self::req_css('contacts');

$companyName = _pro('company-name');
$companyTitle = _pro('company-title');
$addr = _pro('contacts', 'address', 'format');
$email = _pro('contacts', 'email', 'format');
$phone = _pro('contacts', 'phone', 'format');

//$_ctx = $Self::tempCtx(array('var' => ''));
//$var = $_ctx['var'];
?>

<div class="<?=$nIo?>">
    <div fxr class="<?=$nIo?>-item">
        <div class="<?=$nIo?>-label ft-contacts-label">Компания</div>
        <div class="<?=$nIo?>-text ft-contacts-text">
            <?=$companyName?>
            <span sep> • </span>
            <?=$companyTitle?>
        </div>
    </div>

    <div fxr class="<?=$nIo?>-item">
        <div class="<?=$nIo?>-label ft-contacts-label">Адрес</div>
        <div class="<?=$nIo?>-text ft-contacts-text"><?=$addr?></div>
    </div>

	<? if ($email) { ?>
        <div fxr class="<?=$nIo?>-item">
            <div class="<?=$nIo?>-label ft-contacts-label">Электронная почта</div>
            <div class="<?=$nIo?>-text ft-contacts-text"><?=$email?></div>
        </div>
	<? } ?>

    <div fxr class="<?=$nIo?>-item">
        <div class="<?=$nIo?>-label ft-contacts-label">Телефон</div>
        <div class="<?=$nIo?>-text ft-contacts-text"><?=$phone?></div>
    </div>

</div>