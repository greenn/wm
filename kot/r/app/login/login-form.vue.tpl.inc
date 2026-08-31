<?
$Self = _kot::self();
$nFm = $Self::nc('form');

//_kot::req_vue('ui', 'form/field', array(), 'ui-field');
$Self::req_vue('login-field');
$Self::req_vue('login-button');
?>
<div class="<?=$nFm?>">
    <div class="<?=$nFm?>-headline">
        <h2
            :a1="undefined"
            :a2="null"
            :a3="''"
            :a4="false"
            :a5="true"
        >Панель администрирования</h2>
        <h3>портал <?=_proKot('portal-name')?></h3>
    </div>

    <div indent="<?=$nFm?>-after-title"></div>

    <div class="<?=$nFm?>-c">
        <login-field ref="login" label="Пользователь"></login-field>
        <div indent="<?=$nFm?>-between-fields"></div>
        <login-field ref="password" label="Пароль" type="password"></login-field>
        <div indent="<?=$nFm?>-before-button"></div>
        <login-button @click="login">Вход</login-button>
    </div>
</div>