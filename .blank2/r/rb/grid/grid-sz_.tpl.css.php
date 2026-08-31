<?
/*
	css агрегатор, dыввода набора стилей для адаптинхы размеров
		набор MQ
*/

$Self = self_rp();
$nG = $Self::nc();

add_etag_ctx(array(
    //pcss_etag_ctx('transition'),
    etag::extra(
        //[nh] пришедшие аргументы из $_ctx не включаем
        $nG
    ),
    __FILE__
));

$Self::req_css_index(-1, 'grid');

$_ctx = $Self::tplCtx(array(
    'np' => $nG,
    'mq_' => false,
    's_' => false,
        //'sv_' => false,
        //'sh_' => false,

)); //dx($_ctx);

$np = $_ctx['np'];
$N = $_ctx['cols'];

$s_ = $_ctx['s_'];
$sv_ = prop($_ctx, 'sv_', $s_);
$sh_ = prop($_ctx, 'sh_', $s_);

$mq_ = $Self::alignUnitEach($_ctx['mq_']);
$sv_ = $Self::alignUnitEach($sv_);
$sh_ = $Self::alignUnitEach($sh_);

//dx($mq_, $sv_, $sh_);

print $Self::cssTpl('grid-sz', array(
    'np' => $np,
    'cols' => $N,
    'sv' => $sv_[0],
    'sh' => $sh_[0],
));

foreach ($mq_ as $index => $mq) {
    $sz_idx = $index + 1;
    print $Self::cssTpl('grid-sz', array(
        '_mq' => $mq,
        'np' => $np,
        'cols' => $N,
        'sv' => $sv_[$sz_idx],
        'sh' => $sh_[$sz_idx],
    ));
}