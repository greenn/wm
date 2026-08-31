<?#7.5.9
/*
	основной темплейт для вывода сетки
	
*/
$Self = self_rp();
$nG = $Self::nc();

$Self::req_css_index(-1, 'grid');

$_ctx = $Self::tplCtx(array(
	//'pageNames' => false,
	//'o_n' => true, //order (types-classes) number
	'o_c' => array(), //order customs / additional (extra, custom) order classes

    //перечисльение cols (N), для которых надо сделать o_l% / array(3,2);
    'o_l' => array(), //добавить o-классы типа -o{$N}l{$l} - номера строк
	'o_leo' => array(), //добавить o-классы типа -o{$N}l{e/o} - чет/нечет у строк

	'cols' => 0,
	'items' => false, //список контента или контекста для контента-по-вызову
	'tplName' => false, //для формирование контента-по-вызову
	'rpName' => false, //для формирование контента-по-вызову
	'nc' => '',

        'sz' => 0, //[L] size - размер отступов = номер/id набора размеров
	'mq' => 'site', //[L] правила для mq (применение в какой области) = название/id/ обозначения для сетки = (метка по которой можно оформить css-правила)
	//site - на весь сайт
	//content - в контенте
	'dbg' => false, //dbg-outlines

	'contentWrap' => false, //если он есть, создаём враппер для контенйта-в-ячейке = q <?=$nG>-cell-w \ qn нет это <?=$nG>-cell-c = дополнительный враппер после <?=$nG>-cell-w
	'ncCW' => true, //className for Cell Content / при true - <?=$nG>-cell-c
)); //dx($_ctx);

$cols = $_ctx['cols'];
$data = $_ctx['items'];
if (!$data) return;

$total = count($data);

$o_s = array('-od', '-o2', '-of', '-ol'); //ak o_sI = o_sS
//step: классы o{$N}p{$p} используются в grid-sz
for ($N = 2; $N <= $cols; $N++) {
	$o_s []= "-o{$N}";
    for ($n = 1; $n < $N; $n++) {
	    $o_s []= "-o{$N}p{$n}";
	}
}

$o_c = $_ctx['o_c'];

//nz - формирование и добваление классов для o_l будем ниже в цикле foreach
$o_l = $_ctx['o_l'];
if ($o_l === true) $o_l = range(2, $cols); //-o2l1 -o2l2 -o2l3 -o2ll -o3l1 -o3l2 -o3ll = q
foreach ($o_l as $L) { //2,3
	for ($i = 0, $l = 1; $i < $total; $i = $i + $L, $l++) {
		$o_c []= "-o{$L}l{$l}";
	}
	$o_c []= "-o{$L}ll";
}

$o_leo = $_ctx['o_leo'];
if ($o_leo === true) $o_leo = range(2, $cols);
foreach ($o_leo as $l) {
	$o_c []= "-o{$l}le"; //-o1le == -o2
	$o_c []= "-o{$l}lo"; //-o1lo == -od
}

if (is_array($o_c) && $o_c) { //ak o_cI = o_cS
	$o_s = array_unique(array_merge($o_s, $o_c));
}




$data = $_ctx['items'];
$tplName = $_ctx['tplName'];
$rpName = $_ctx['rpName'];

$np = $_ctx['nc'];
$sz = $_ctx['sz'];
$mq = $_ctx['mq'];

$n_oo = $_ctx['dbg'] ? 'oo' : '';
$a_cols = $cols ? 'cols="'.$cols.'"' : ''; //qL
$a_sz = $sz ? 'sz="'.$sz.'"' : ''; //qL
$a_mq = $mq ? 'mq="'.$mq.'"' : ''; //qL





$hasCW = !!$_ctx['contentWrap'];
$ncCW = $_ctx['ncCW'];
if ($ncCW === true) $ncCW = "$nG-cell-c";
if (is_string($_ctx['contentWrap'])) $ncCW = $_ctx['contentWrap'];
?>

<?//=$Self::tpl('text-intro');?>

<div fc class="<?=$nG?> <?="$np $n_oo"?>" <?="$a_cols $a_sz $a_mq"?>>
    <div fc class="<?=$nG?>-sep -o -ob"></div>
    <?
    reset($data); $firstIndex = key($data);
    end($data); $lastIndex = key($data);
    foreach ($data as $index => $item) {
        $num = $index + 1;
	    $o_nsI = $Self::nc_o(array($index, $firstIndex, $lastIndex), $o_s);
	    //$o_nsS = $Self::nc_o(array($index, $firstIndex, $lastIndex), $o_sS);
	    $o_nsS = $o_nsI;

	    $content = $Self::get_content($item, $tplName, $rpName);
	    /*
	        класс -o нужен для обращения к ячейке через css, когда там нет класса
	            например в cols-w, иначе другое правило с классом имеет большой приоритет
	    */
        if ($hasCW) {
	        $content = join('', array(
		        '<div class="'.$ncCW.'">',
	                $content,
                '</div>'
            ));
        }
    ?>
        <div fl class="<?=$nG?>-cell -o <?=$o_nsI?>" n="<?=$num?>">
            <div class="<?=$nG?>-cell-b">
                <div t mc class="<?=$nG?>-cell-w">
                    <?=$content?>
                </div>
            </div>
        </div>
        <div fc class="<?=$nG?>-sep -o <?=$o_nsS?>"></div>
    <? } ?>
</div>