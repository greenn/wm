<?

$Self = _rb::self();

$_ctx = $Self::tempCtx(array(
	'method' => '_css',
	'fs0' => 18,
	'base-a' => true,
));
$method = $_ctx['method'];
$fs0 = $_ctx['fs0'];

//01
if ($fs0 === true) {
	$fs0 = $method('fs_', 't', 1); //iq/config/css/site-fonts.inc:49
}

?>

BODY {
    font-family: <?=_css('fSS_')?>;
    font-size: <?=$fs0?>px;
    color: <?=_css('text-main')?>;
}


<? if ($_ctx['base-a']) { ?>

    A {
        cursor: pointer;
        text-decoration: underline;
        color: <?=_css('tc1')?>;
    }
    A:hover {}
    A[nolink] { cursor: default; }
    A[nolink][cp] { cursor: pointer; }

<? } ?>

<? if (!1) { ?>
    [class^="ft-"], <?// для первого класса?>
    [class*=" ft-"] <?// если класс не первый?> {
    word-wrap: break-word; <?//устаревшее свойство, но поддерживается во всех браузерах. ?>
    overflow-wrap: break-word; <?// Рекомендуемый вариант для большинства случаев ?>

    overflow-wrap: break-word;
    word-wrap: break-word; /* Для старых браузеров */

	<? if (0) { ?>
        word-break: keep-all; <? //Не позволяет разрывать слова, даже если они выходят за границы. ?>
	<? } ?>
    }
<? } ?>
