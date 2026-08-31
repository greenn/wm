<?
$Self = _site::self();
$nF = $Self::nc('F');

//$Self::req_css('blank');
//$Self::req_js('blank');

$_ctx = $Self::tempCtx(array());

_site::req_vue('order', 'form-field');

?>


<div class="<?=$nF?>">

    <div class="<?=$nF?>-item">
        <form-field label="Имя" req="true" placeholder="Ваше имя"></form-field>
    </div>
    <div class="<?=$nF?>-item">
        <form-field label="Телефон" req="true"  placeholder="Контактный телефон"></form-field>
    </div>
    <div class="<?=$nF?>-item">
        <form-field label="Время для звонка" req="false" placeholder="Удобное время для звонка"></form-field>
    </div>
    <div class="<?=$nF?>-item">
        <form-field label="Электронная почта" req="false" placeholder="(по желанию)"></form-field>
    </div>

    <div h20></div>

    <div tc class="<?=$nF?>-item">
		<?=lay_tpl('button', 'r-button-1', array(
			'size' => 'small',
			'text' => 'Отправить',
			'@click' => "clickFake",
		))?>
    </div>

    



</div>