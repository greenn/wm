<?
/*
    агрегатор для grid-правил (css)
    oo site/rp/grid/test/grid-tpl-css.eg.php
*/

$Self = self_rp();
$nG = $Self::nc();

add_etag_ctx(array(
    etag::extra(
        $nG
    ),
    __FILE__
));

$Self::req_css_index(-1, 'grid');

$_ctx = $Self::tplCtx(array(
    'np' => false,
    'ng' => false,
    'cols' => 0,
    'mq_' => array(), //стек mq-правил (изменений)

    //optList
    # 'wx' => 0,
    # 'wxI' => 0,
    
    //szList > grid-sz.tpl.css.php
    # 's' => 0,


    # 'sh' => 0, //horizontal
    # 'shs' => 0, //horizontal side - по краям: первый (left), и последний (right)
    # 'shsHalf' => true, ////horizontal side half

    # 'sv' => 0, //vertical
    # 'svs' => 0, //vertical side - по краям: первый (top), и последний (bottom)
    # 'svsHalf' => true, //vertical side half
    # 'svt' => 0,  //vertical top
    # 'svtHalf' => true,  //vertical ещз half
    # 'svb' => 0,  //vertical bottom
    # 'svbHalf' => true,  //vertical bottom half

    'colsCss' => true,
)); //dx($_ctx);

$ng = $_ctx['ng'];
$np = $_ctx['np'];
if (!$np) $np = $ng;

$cols = $_ctx['cols'];
$has_cols = $_ctx['colsCss'];
$mq_ = $_ctx['mq_'];
$has_mq = !!$mq_;

$baseCtx = array(
    'np' => $np
);

$optCtx = array();
$optList = array('wx', 'wxI', 'ng');
foreach ($optList as $key) {
    if (array_key_exists($key, $_ctx)) {
        $optCtx[$key] = $_ctx[$key];
    }
}
$has_opt = !!$optCtx;

$colsCtx = array(
    'cols' => $cols
);

$szCtx = array(
    'cols' => $cols
);
$szList = array('s', 'sv', 'sh',  'shs', 'shsHalf', 'svs', 'svsHalf', 'svt', 'svtHalf', 'svb', 'svbHalf');
foreach ($szList as $key) {
    if (array_key_exists($key, $_ctx)) {
        $szCtx[$key] = $_ctx[$key];
    }
}
$has_sz = count($szCtx) > 1;

//dpx($_ctx, $optCtx, $has_opt, $optCtx, $has_cols, $colsCtx, $has_sz, $szCtx, $has_mq, $mq_);
if ($has_opt) {
    print $Self::cssTpl('grid-opt', $baseCtx + $optCtx);
}

if ($has_cols) {
    print $Self::cssTpl('grid-cols', $baseCtx + $colsCtx);    
}

if ($has_sz) {
    print $Self::cssTpl('grid-sz', $baseCtx + $szCtx);
}

//step: для mq-конфигов, потвторяем этот жде темплейт для значений MQ
if ($has_mq) foreach ($mq_ as $conf) {
    $mq = $conf[0];
    $ctx = $conf[1];
    $mqCtx = array('_mq' => $mq); //просто запускаем отдельный mq-конфиг, с пометкой _mq, (описанная в grid.inc::^cssTpl()) которая сама оборачивает в media-query результат
    $szCtx = array_replace($szCtx, $ctx); //step: наследуем предыдущие контексты
    print $Self::cssTpl('grid', $baseCtx + $mqCtx + $szCtx);
}