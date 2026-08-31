<?

_needphp('fq/attr.class');

$as_mqr1 = attr::as(array(
	'mqrd' => false,
	'mqr' => 1000,
	'mqrc' => join(',', array(
		's='.array_sum([80, /*-10*/]),
		'ws=20',
	)),
	//'mqrs' => '800=10:vw' //настройки для mqrc.s
	'mqrs' => 'mq=800:10vw' //настройки для mqrc.s

));
//dx($as_mqr);


$as_mqr2 = attr::as(array(
	'mqr',
	//attr::out('mqr', 1200),
	attr::out('mqrc', join(',', array(
		'w=200', //уменьшаем постепено ширину () блока на 200px
	))),
	attr::out('mqrw', join(',', array(
		'before=150', //начинааем отнимать за 150px до срабатывания scale
		'restore-before=true', //начинааем отнимать за 150px до срабатывания scale
	))),
	//'mqrd'
));


$Self = _rb::self();
$nT1 = $Self::nc('T1');

_rb::req_css('css', 'aq');

$_ctx = $Self::tempCtx(array(
	'text' => ''
));


$as_mqr = attr::as(array(
	'mqrd' => true,
	'mqr' => 600,
));

$appendText = $_ctx['text'];
if ($appendText) $appendText = ': '.$appendText;
?>
<style>
	.mqr-w .<?=$nT1?> {
		outline: 2px solid cadetblue;
    }
	.<?=$nT1?> {
        outline: 2px dashed cadetblue;

		background-color: lightpink;
		width: 400px;
	}
</style>
<section tc hm80 mt20 class="<?=$nT1?>" <?=$as_mqr?>>
	test-1<?=$appendText?>
</section>
