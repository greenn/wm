<?
$Self = _lay::self();
$Self::req_css(-1, 'r-button-1/r-button-1'); //-1 пока что думается что бы было после ft.css
$nRB1 = $Self::nc('RB1');
$_ctx = $Self::tempCtx(array(
    'nc' => '',
    'ft' => 'ft-rbutton-1',
    'text' => basename(__FILE__, '.tpl.php'),
    'nobr' => true,
    '@click' => '',
));
$nc = $_ctx['nc'];
$text = $_ctx['text'];
$ft = $_ctx['ft'];
$a_nobr = $_ctx['nobr'] ? 'nobr' : '';

$a_vueClick = attr::out_val('@click', $_ctx['@click']);
?>

<button oh r class="<?=$nRB1?> <?=$nc?>" rst="button" <?=$a_vueClick?>>
    <span r zi3 ib <?=$a_nobr?> class="<?=$nRB1?>-c <?=$ft?>"><?=$text?></span>
    <span al zi1 ib class="<?=$nRB1?>-bg"></span>
    <span al zi2 ib class="<?=$nRB1?>-hover"></span>
</button>