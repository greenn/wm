<? $arg;
/*
    ещё есть overflow-wrap: anywhere;

    [ob]
       это не
            pcss('word-wrap', 'break-word')
       а просто
            pcss('break-word')

*/
//Soft hyphen:¦&#173;¦&shy;¦0xCA¦
$opt = isset($arg[1]) ? $arg[1] : array();
if (!is_array($opt)) {
    $opt = array($opt);
}

$method = 1;  //.dont-break-out {}
//$method = 2; # https://justmarkup.com/log/2015/07/dealing-with-long-words-in-css
/*
    как это работает
        так? array('all')
*/
?>
<?if ($method === 1) { ?>
    <?// These are technically the same, but use both ?>
    overflow-wrap: break-word;
    word-wrap: break-word;
    <?if (in_array('all', $opt)) {?>
        -ms-word-break: break-all;
        <?// This is the dangerous one in WebKit, as it breaks things wherever ?>
        word-break: break-all;
    <?}?>
    <?// Instead use this non-standard one: ?>
    word-break: break-word; <?//=?>
    <?// Adds a hyphen where the word breaks, if supported (No Blink) ?>
    -ms-hyphens: auto;
    -moz-hyphens: auto;
    -webkit-hyphens: auto;
    hyphens: auto;
<?} ?>
<?if ($method === 2) { //не работал там где надо?>
    overflow-wrap: break-word;
    word-wrap: break-word;
    -webkit-hyphens: auto;
    -ms-hyphens: auto;
    -moz-hyphens: auto;
    hyphens: auto;
<?} ?>
<?/* reset values:
    overflow-wrap: normal;
    word-wrap: normal;
    word-break: normal;
    -ms-hyphens: unset;
    -moz-hyphens: unset;
    -webkit-hyphens: none;
    hyphens: none;
*/?>
