<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

need::php('fq/attr.class');

d((array)'string-2');

d(join(' ', array_filter(array(
    '', '0', '1', 0, 1
))));


d(
    attr::out(1),
    attr::out('')
);


if (1) {

	$as_mqr = array(
		'mqrd' => false,
		'mqr' => 1000,
		'mqrc' => join(',', array(
			's='.array_sum([80, /*-10*/]),
			'ws=20',
		)),
		'mqrs' => '800=10:vw' //настройки для mqrc.s

	);

	d(
		attr::as($as_mqr)
    );
}