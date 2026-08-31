<?
$Self = _rt::name('test-vue-base-tt1');

$n = $Self::nc();

$Self::req_css('app');
$Self::req_js('app');

$Self::req_vue('app-head');
$Self::req_vue('app-head', array(), 'app-head--2');
//_metro::req_vue('ui');
?>

<div r class="<?=$n?>">
    <h1><?=$n?></h1>
    <h2>{{ headline }}</h2>
    <app-head></app-head>
    <app-head--2></app-head--2>

    <!--<sys-msg></sys-msg>
    <popup></popup>-->
</div>