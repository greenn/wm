<?#0.1

//https://stackoverflow.com/questions/12277945/php-how-do-i-round-down-to-two-decimal-places
function floor_round($val, $precision) {
	$half = 0.5 / pow(10, $precision); // Can be cached in a lookup table
	return round($val - $half, $precision);
}

/*
	получить в впроцентах размер ячеек и отступов между ними, по следующим данным:
	$cs_w — column-separator-width - желаемый отступ между ячейками
    $w_w — wrapper-width - ширина блока с ячейками
    $c_q — column-quantity - кол-во ячеек
    $rp_v — round-precision-value - степень округления (кол-во десятых после запятой)

*/
function expect_pct_col_sizes($cs_w, $w_w, $c_q, $rp_v = 4){
	$cs_w_P = round($cs_w / $w_w * 100, $rp_v); //желаемый отступ между ячейками (в процентах)
	if ($c_q < 2) $cs_w_P = 0;
	$c_w_P = floor_round((100 - $cs_w_P * ($c_q - 1)) / $c_q, $rp_v);
	return array($c_w_P, $cs_w_P);
}