<?#8.2.16 - aq.css
/*
    oo site/css/inc/q.css.inc
*/
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
$Self = _rb::self();

$tr = css('tr0');
$trq = css('trq1');
headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra($tr, $trq),
    __FILE__
), SITE_CACHE);
?>
<?//AQ(c)ored |q|cq{ka fq}| - /awkward ~ A- attribute; Q - quick; Core - основа ?>

[v-cloak] { display: none !important; }

[a], [al] { position: absolute; }
[a*="l"], [al], [bal]::before, [aal]::after { left: 0; }
[a*="t"], [al], [bal]::before, [aal]::after { top: 0; }
[a*="r"], [al], [bal]::before, [aal]::after { right: 0; }
[a*="b"], [al], [bal]::before, [aal]::after { bottom: 0; }
[a*="h"] { height: 100%; }
[a*="w"] { width: 100%; }

*[ba]::before, *[aa]::after, *[bal]::before, *[aal]::after {
    content: '';
    position: absolute;
}

[avh] {
    position: absolute;
    left: 50%;
    top: 50%;
    <?=pcss('transform', 'translate(-50%, -50%)')?>;
}

[ach] {
    position: absolute;
    left: 50%;
    <?=pcss('transform', 'translateX(-50%)')?>;
}

*[acr]:after {
    content: '';
    display: block;
    position: absolute;
    left: 0; right: 0;
    top: 0; bottom: 0;
    z-index: 1000;
}

[nos] {
    <?=pcss('user-select', 'none')?>
}

[noe],
[cover],
[covered] {
    pointer-events: none;
}

[covered] {
    position: relative;
    display: inline-block;
}
[covered]::before {
    content: '';
}
[cover],
[covered]::before {
    display: block;
    position: absolute;
    z-index: 1;
    left: 0; right: 0;
    top: 0; bottom: 0;
    cursor: default;
}

[r] { position: relative; }
[as] { position: sticky; }
[f], [ff], [al][f] { position: fixed; }
[fi] { position: fixed !important; }
[f*="l"], [ff] { left: 0; }
[f*="t"], [ff] { top: 0; }
[f*="r"], [ff] { right: 0; }
[f*="b"], [ff] { bottom: 0; }
[f*="h"] { height: 100%; }
[f*="w"] { width: 100%; }

[ffm] { font-family: monospace; }
    [ffm="*"], [ffm="*"] * { font-family: monospace; }

[oh] { overflow: hidden; }
[os] { overflow: scroll; }
[osy] { overflow-y: scroll; }
[osx] { overflow-x: scroll; }

[fl] { float: left; }
[fr] { float: right; }
[fc] { clear: both; }
[flc] { clear: left; }
[frc] { clear: right; }

[ib] { display: inline-block; }
[b], [bk] { display: block; }
[t] { display: table; }
[tw] { display: table; width: 100%; }
[it] { display: inline-table; }
[no], [noi] { display: none; }
[ni] { display: none !important; }
[h] { visibility: hidden; }
<? if (0 && 'id') { ?>
    [no="no"] { display: block; }
<? } ?>
[hide="yes"], [show="no"] { display: none; }
[hide="no"], [show="yes"] { display: block; }

    [bx] {
        box-sizing: border-box; /* Учитывает padding */
    }

[mc], [tc] { margin-left: auto; margin-right: auto; }
[tc] { display: table; }


[nobr] { white-space: nowrap }
[ta="c"], [txc] { text-align: center; }
[ta="l"], [txl] { text-align: left; }
[ta="r"], [txr] { text-align: right; }
[ta="j"], [txj] { text-align: justify; }
[va] { vertical-align: middle; }

[tdn], [tdn] * { text-decoration: none; }
[tdu], [tdu] * { text-decoration: underline; }

<? for ($n = 1; $n <=9; $n++) { $fw = $n * 100; ?>
    [fw<?=$n?>] { font-weight: <?=$fw?>; }
    [fwi<?=$n?>] { font-weight: <?=$fw?> !important; }
<? } ?>
[fwn] { font-weight: 400; }
[fwb] { font-weight: 700; }


[o] { outline: 1px solid black; }
[o1], [o2], [o3], [o4], [ot1],
[os1] { outline-width: 1px }
[os2] { outline-width: 2px }
[os3] { outline-width: 3px }
[o$="s"], [o1], [o2], [o3], [o4] { outline-style: solid; }
[o$="t"], [ot1] { outline-style: dotted; }
[o$="d"] { outline-style: dashed; }
[o^="1"], [o1], [ot1] { outline-color: saddlebrown; }
[o^="2"], [o2] { outline-color: darkorange; }
[o^="3"], [o3] { outline-color: darkslateblue; }
[o^="4"], [o4] { outline-color: orangered; }

<?if(0){?>.z1 {}<?}?>
    <? for ($n = 0; $n <=10; $n++) { $z = $n * 100; ?>
        [z<?=$n?>] { z-index: <?=$z ? $z : 0?>; }
    <? } ?>
    <?// приоритет от 200 до 1?>
    <? for ($n = 0; $n <=10; $n++) { $z = 200 - ($n - 1) * 20; ?>
        [zp<?=$n?>] { z-index: <?=$z ? $z : 1?>; }
    <? } ?>
<? for ($n = 1; $n <=1000; $n++) { ?>
    [zi<?=$n?>] { z-index: <?=$n?> }
<? } ?>

<? for ($n = 1; $n <=10; $n++) { $z = $n; ?>
    [zy<?=$n?>] { z-index: -<?=$z?>; }
<? } ?>

[col-indent],
[indent] {
    font-size: 0;
    display: block;
    margin-top: 0;
}
[indent] {
    height: 0;
    <?=pcss('transition', array(
        "width $tr",
        "height $tr",
        "margin-top $tr",
    ))?>
}
[col-indent] {
    <?=pcss('transition', "width $tr")?>
    height: inherit;
}
[col-indent]:after,
[col-indent]:before {
    content: '';
    display: block;
    <?=pcss('transition', array(
        "width $tr"
    ))?>
}

[cp] { cursor: pointer; }
[cd] { cursor: default; }
[cd_] { cursor: default; <?=pcss('user-select', 'none')?> }
[ct] { cursor: text; }
[cno] { cursor: not-allowed; }
[ch] { cursor: help; }
[chr] { cursor: crosshair; }
[cl] { cursor: cell; }
[cg] { cursor: grab; }
[cg="on"], [cgd] { cursor: grabbing; }

[hmp100] { min-height: 100% }

<?/* exp h, p(tbrl) m(tbrl)*/ ?>
<? if ('eg' && false) { ?>
    <? for ($x = 0; $x <= 19; $x++) { ?>
    [h="<?=$x?>"] { height: <?=$x?>px; }
    <? } ?>
    <? for ($x = 20; $x <= 99; $x = $x + 5) { ?>
    [h="<?=$x?>"] { height: <?=$x?>px; }
    <? } ?>
    <? for ($x = 100; $x <= 249; $x = $x + 10) { ?>
    [h="<?=$x?>"] { height: <?=$x?>px; }
    <? } ?>
    <? for ($x = 250; $x <= 1000; $x = $x + 50) { ?>
    [h="<?=$x?>"] { height: <?=$x?>px; }
    <? } ?>
<? } ?>
<?
    $list = array();
    $map = array(
        //'xt' => 'top', 'xb' => 'bottom', 'xl' => 'left', 'xr' => 'right', //L
        'tx' => 'top', 'bx' => 'bottom', 'lx' => 'left', 'rx' => 'right',
        'ty' => 'top', 'by' => 'bottom', 'ly' => 'left', 'ry' => 'right',
        'tp' => array('top', '%'), 'tpy' => array('top', '%'),
        'bp' => array('bottom', '%'), 'bpy' => array('bottom', '%'),
        'lp' => array('left', '%'), 'lpy' => array('left', '%'),
        'rp' => array('right', '%'), 'rpy' => array('right', '%'),

        'lh' => 'line-height',
        'fs' => 'font-size',

        'br' => 'border-radius',

        'w' => 'width',
        'h' => 'height',
        'hp' => array('height', '%'),
        'wp' => array('width', '%'),
        'hm' => 'min-height',
        'wm' => 'min-width',
        'hmp' => array('min-height', '%'), //используется только hmp100 (вынесено отдельно)
        'wmp' => array('min-width', '%'),
        'm' => 'margin', 'my' => 'margin',
        'p' => 'padding',
        'pt' => 'padding-top',
        'pb' => 'padding-bottom',
        'pr' => 'padding-right',
        'pl' => 'padding-left',
        'mt' => 'margin-top', 'mty' => 'margin-top',
        'mb' => 'margin-bottom', 'mby' => 'margin-bottom',
        'mr' => 'margin-right', 'mry' => 'margin-right',
        'ml' => 'margin-left', 'mly' => 'margin-left',
    );
    $extra = array(//$extraRules
        'pt' => 'pv',
        'pb' => 'pv',
        'pr' => 'ph',
        'pl' => 'ph',
        'mt' => 'mv', 'mty' => 'mvy',
        'mb' => 'mv', 'mby' => 'mvy',
        'mr' => 'mh', 'mry' => 'mhy',
        'ml' => 'mh', 'mly' => 'mhy',
    );
    $propogation = array(//$propogationRules
        'fs' => true,
    );
    $negative = array(
        'ty', 'by', 'ly', 'ry',  'tpy', 'bpy', 'lpy', 'rpy',
        'my',  'mty', 'mby', 'mry', 'mly',  'mhy', 'mvy',
    );

    $list['br'] = array(
        "1" => array(0, 99),
        "10" => array(100, 300),
    );

    $list['w'] = array(
        "1" => array(0, 149),
        "5" => array(150, 299),
        "10" => array(300, 499),
        "50" => array(500, 1000),
    );
    $list['h'] = $list['lh'] = array(
        "1" => array(0, 99),
        "5" => array(100, 149),
        "10" => array(150, 999),
        "50" => array(1000, 2000),
    );
    $list['hm'] = $list['wm'] = array(
        "1" => array(0, 49),
        "5" => array(50, 149),
        "10" => array(150, 199),
        "50" => array(200, 500),
        //"100" => array(500, 2000),
    );


    $list['fs'] = array(
        "1" => array(0, 200),
    );

    $list['hp'] = $list['wp'] = array(
        "1" => array(0, 100),
    );
    $list['hmp'] = $list['wmp'] = array(
        "1" => array(0, 100),
    );


    $list['my'] =
    $list['p'] = $list['m'] = array(
        "1" => array(0, 99),
        "5" => array(100, 249),
        "10" => array(250, 1000),
    );


    //$list['xt'] = $list['xr'] = $list['xb'] = $list['xl'] = //L
    $list['ty'] = $list['ry'] = $list['by'] = $list['ly'] =
    $list['tx'] = $list['rx'] = $list['bx'] = $list['lx'] = array(
        "1" => array(0, 149),
        "10" => array(150, 299),
        "50" => array(300, 1000),
    );

    $list['tpy'] = $list['bpy'] = $list['lpy'] = $list['rpy'] =
    $list['tp'] = $list['bp'] = $list['lp'] = $list['rp'] = array(
        "1" => array(0, 99),
        "50" => array(100, 1000),
    );

    //pt, pb, pr, pl
    //mt, mb, mr, ml,
    //mty, mby, mry, mly,
    foreach (str_split('pm') as $L1) {
        foreach (str_split('tbrl') as $L2) {
            $list[$L1.$L2] = $list['p'];
            if ($L1 == 'm') $list[$L1.$L2.'y'] = $list['m'];
        }
    }

    $css = array();
    $attrValueView = gt_on('av', false);
    foreach ($list as $a => $ctx) {
        $prop = $map[$a];
        $unit = 'px';
        if (is_array($prop)) list($prop, $unit) = $prop;
        foreach ($ctx as $inc => $range) {
            $addRule = prop($extra, $a, '');
            $propg = prop($propogation, $a, '');
            for ($x = $range[0]; $x <= $range[1]; $x = $x + $inc) {
                $y = ''; //минус
                if (in_array($a, $negative)) $y = "-";

                $rules = array();
                $rules []= "[$a$x]";
                if ($addRule) {
                    //например для mt, добавляется mh из $extra
                    if ($attrValueView) $rules []= "[$addRule=\"$x\"]"; //L: a="value"
                    $rules []= "[$addRule$x]"; //ak $addRule
                }

                if ($attrValueView) $rules []= "[$a=\"$x\"]"; //L: a="value"
                if ($propg) {
                    $rules []= "[$a{$x}_]";
                    $rules []= "[$a{$x}_] *";
                }

                $css []= join(', ', $rules)." { $prop: {$y}{$x}{$unit}; }";

            }
        }
    }
    print join(' ', $css);
?>

[anff][class] {
    animation-fill-mode: forwards;
}

<? include $Self::path('aq/aq-animation.css.inc')  ?>

<?//чётонето?>
<?//for ($inc = 1, $i=100)?>
<? if(0) for ($val = 100, $T = 1000, $inc = 50; $val <= $T; $val = $val + $inc) { ?>
[an="400"] { <?=pcss('animation-duration', $val)?> }
<? } ?>


<? include $Self::path('aq/aq-cored.css.inc')  ?>

<? //include 'aq-custom.css.inc'; ?>

<?//                ahover / aclick         ?>
[rclick], [_rclick], [rhover], [_rhover] {
    position: relative;
}

<? for ($i = 1; $i <= 2; $i++){
    $n = $i;
?>
.-click [_rclick="t<?=$n?>"],
[_rclick="t<?=$n?>"].-click,
[rclick="t<?=$n?>"].-click,
[rclick="t<?=$n?>"].-click {
    top: <?=$n?>px;
}
<? } ?>


.-hover [_rhover="r1"],
[_rhover="r1"].-hover,
[rhover="r1"].-hover {
    right: 1px;
}


*[ifx] {
    display: inline;
}
*[ibfx] {
    display: inline-block;
}
*[bifx] {
    display: block;
}
*[iflx] IMG,
*[ifx] IMG,
*[ibfx] > [ibfx],
*[ibfx] IMG,
*[bifx] IMG,
*[iifx] IMG {
    float: left;
}