<?//L?>
<?//Q(c)ored |q|cq{ka fq}|?>
/* c o r e d */
.f { position: fixed; }
.r { position: relative; }
.a { position: absolute; }
.al, .al_a:after, .al_b:before { position: absolute;  left: 0; top: 0; right: 0; bottom: 0; }
    .al_a:after, .al_b:before { content: ''; }
.lt { left: 0; top: 0; }
.rt { right: 0; top: 0; }
.lb { left: 0; bottom: 0; }
.rb { right: 0; bottom: 0; }
    .lr, .lrt, .lrb { left: 0; right: 0; }
    .tb, .tbr, .tbl { top: 0; bottom: 0; }
    .t0, .lrt { top: 0; }
    .r0, .tbr { right: 0; }
    .b0, .lrb { bottom: 0; }
    .l0, .tbl { left: 0; }
.n { display: none; }
.ni { display: none !important; }
.h { visibility: hidden; }
.f { position: fixed; }
.fl { float: left; }
.fr { float: right; }
.fc { clear: both; }
.flc { clear: left; }
.frc { clear: right; }
.oh { overflow: hidden; }
.mc { margin-left: auto; margin-right: auto; }
.tc { text-align: center; }
.tal { text-align: left; }
.tar { text-align: right; }
.tj, .tjf { text-align: justify; }
/*.tjf { text-align-last: justify; }*/
.tjf:after { content: ''; display: inline-block; width: 100%; }
.nobr { white-space: nowrap }
.cp { cursor: pointer; }
.cd { cursor: default; }
.ct { cursor: text; }
.cno { cursor: not-allowed; }
.ch { cursor: help; }
.b { display: block; }
.t { display: table; }
.tf { display: table; width: 100%; }
.td { display: table-cell; }
.tr { display: table-row; }
.ib { display: inline-block; }
.ii { display: inline; }
.it { display: inline-table; } <?//|it|ibt|?>
.fx { display: flex; }
    .fx1 { flex: 1; }
    .fxr { display: flex; flex-direction: row; }
    .fxg { flex-grow: 1; }
    .fxc { display: flex; flex-direction: column; }
<? for ($n = 0; $n <=10; $n++) { ?>
.z<?=$n?> { z-index: <?=$n * 10?>; }
<? } ?>
.tx-b, .tx-b * { font-weight: bold; }
.o1 { outline: 1px solid saddlebrown; }
.o2 { outline: 1px solid darkorange; }
.o3 { outline: 1px solid darkslateblue; }
.o4 { outline: 1px solid orangered; }