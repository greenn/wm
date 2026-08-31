<?
$Self = _rb::self();

$_ctx = $Self::tempCtx(array(
	'page-title' => false,
    'refresh' => true,
    'process' => array(),
    'date-interval' => false,
    'success' => array(),
    'error' => 0, //false для скрытия
    'error-msg' => false,
    'warn' => 0, //false для скрытия
    'before' => '',

));
//d($_ctx);
//$title = $_ctx['title'];
$pageTitle = $_ctx['page-title'];
$refresh = $_ctx['refresh']; //$refresh = false;
$process = $_ctx['process'];
$dateInterval = $_ctx['date-interval'];
$before = $_ctx['before'];
$success = $_ctx['success'];
$successMsg = prop($success, 'msg');
$error = prop($success, 'error'); //$successError
$errorMsg = prop($success, 'error-msg'); //$successError
$warn = prop($success, 'warn'); //$successWarn

$processList = rb_uc_upd::apply($process, $dateInterval);
$fin = !rb_uc_upd::$break;

if ($fin) {
	$refresh = false;
}

//dx($processList);
?>
<html>
    <head>
        <title><?=$pageTitle?></title>
        <? if ($refresh) { // Обновление страницы каждую 1 секунду?>
            <meta http-equiv="refresh" content="1" />
        <? } ?>
    </head>
    <body>

    <? if ($before) { ?>
        <?=$before?>
    <? } ?>
    <? foreach($processList as $title => $percentage){ ?>
        <?=$title?>: <?=round($percentage, 3)?>%
        <br />
    <? } ?>

    <? if ($fin && $success) { ?>
		<? if ($successMsg) { ?>
            <div style="color: blue"><?=$successMsg?></div>
		<? } ?>
		<? if (is_integer($error)) { ?>
            <div style="color: red">Ошибки: <?=$error?></div>
            <?/*
                <span style="color: <?= $error ? 'red' : 'green'?>"><?=$error?></span>
           */?>
		<? } ?>
		<? if ($errorMsg) { ?>
            <div style="color: red"><?=$errorMsg?></div>
		<? } ?>
		<? if (is_integer($warn)) { ?>
            <div>
                <span style="color: orange">Предупреждения: <?=$warn?></span>
                <? if ($warn) { ?>(см. в логе)<? } ?>
            </div>
		<? } ?>
    <? } ?>
    </body>
</html>