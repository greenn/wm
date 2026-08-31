<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');
_needphp('dirToArray.class');

$Self = _kot::self();
$nP = $Self::nc('page');
$nFm = $Self::nc('form');
$nFd = $Self::nc('field');
$nB = $Self::nc('button');

$tr = _cssKot('tr0');

$css = array();
$bgDir = '/bg/41p';
$bgPics = dirToArray::apply(array(
	'path' => kot_i::uri($bgDir),
	'keepDots' => false,
	'depth' => 0,
));

headers('css', 'utf8', 'nosniff', etag::ctx(
    //etag::extra(),
    __FILE__
));
?>

BODY[bg],
.<?=$nP?> {
    background-size: 41%;
    background-repeat: repeat;
    background-position: left top;
}

<? foreach (array_keys($bgPics) as $index => $pic) { $N = $index + 1 ?>
BODY[bg="<?=$N?>"], .<?=$nP?>.bg-<?=$N?> {
    background-image: url('<?=kot_i::uri("$bgDir/$pic")?>');
}
<? } ?>

[indent="<?=$nFm?>-after-title"] { height: 40px; }
[indent="<?=$nFm?>-between-fields"] { height: 24px; }
[indent="<?=$nFm?>-before-button"] { height: 52px; }


.<?=$nFm?>-headline {
    color: #eeecdc;
    text-shadow: 1px 1px 2px #171820;
    letter-spacing: -1px;
}
.<?=$nFm?>-headline H2 {
    <?/*color: #11141b;
    text-shadow: 1px 1px 1px #eeecdc;*/?>
    font-size: 25px;
    font-weight: 600;
    margin-bottom: 5px;
}
.<?=$nFm?>-headline H3 {
    color: #eeecdc;
    text-shadow: 1px 1px 2px #171820;
    font-size: 16px;
    font-weight: 500;
}

.<?=$nFm?>-headline H2 {

}


.<?=$nFd?> {
    <?=pcss('transition', array(
        "background $tr",
    ))?>

    background: linear-gradient(to bottom right, #fdfae8, #576b85);
    padding: 2px;
    border-radius: 32px 32px 16px 32px;
    border-radius: 32px 32px 32px 16px;
}
.<?=$nFd?>.-focus {
    background: linear-gradient(to top right, #f5e6cd, #576b85);
}

.<?=$nFd?>-c {
    background: linear-gradient(to bottom right, #3f5a6f, #171820);
    padding: 3px 32px;
    border-radius: 32px;
}

.<?=$nFd?> INPUT,
.<?=$nFd?> INPUT::placeholder {
    color: #c3c6c7;
    font-size: 14px;
}

    .<?=$nFd?> INPUT:-ms-input-placeholder,
    .<?=$nFd?> INPUT::-webkit-input-placeholder,
    .<?=$nFd?> INPUT::-moz-placeholder{
        font-size: 14px;
        color: #c3c6c7;
        opacity: 1; /* Firefox уменьшает непрозрачность плейсхолдера по умолчанию */
    }


.<?=$nB?> {
    <?=pcss('transition', array(
        "color $tr",
    ))?>

    background: linear-gradient(to bottom, #f6f9f9, #385874 70%, #11070c 95%);
    padding: 10px;
    border-radius: 15px;
    color: #171820;
    color: black;
}

.<?=$nB?>:hover {
    color: #c3c6c7;
}

