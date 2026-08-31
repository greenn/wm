<?
_needphp('fq/str/str2val');

$Self = _kot::self();

include_once $Self::path($Self::relDir("passes/passes.fn.inc"));

$_ctx = $Self::tempCtx(array(
	//'targets' => array(),
	//'id' => "2",
	'passes_min' => "1",
	'passes_min-fix' => "true",
	'interval' => "last-7d",
	//'interval-fix' => "true"
	//'from' => '',
	//'to' => '',
	//'name' => '', //"passes/passes-qy"
	'station' => false,  //"19,20"

));
//d($_ctx);

$passes = str2val($_ctx['passes_min']);
$hasPasses = str2val($_ctx['passes_min-fix']);
$interval = $_ctx['interval'];
$stations = $_ctx['station'];
if (is_string($stations)) $stations = explode(',', $stations); 
if (!$stations) $stations = array(); 
$stationsN = count($stations);

//$start_time = microtime(true); // Замеряем текущее время после выполнения скрипта

//step: вычисление значений интервала
$intervalData = targets_aggregate::convertInterval($interval);



if ($passes === 0) {
	//case: при не зафиксированном кол-ве (!$hasPasses)
		//при $hasPasses - 0 не даст свалидироваться
	//кол-во проходов 0 и оно не зафиксированно
	$q = targets_aggregate::getRandomPerDay($intervalData);

} else {

	//step: распределение от 1 до 20 на 1000000
	$distribution = generatekotPasses(
		targets_aggregate::getRandomPerDay(),
		4, // Среднее значение (наиболее часто встречающееся)
		4 // Стандартное отклонение (изменчивость данных)
	); //~ [ проходы => кол-во пассажиров ]
	//d($distribution);
	//$end_time = microtime(true);
	//$execution_time = ($end_time - $start_time); // Вычисляем разницу во времени и преобразуем её в миллисекунды
	//dx($distribution, $execution_time);



	$q = 0;
	//d($distribution, $passes = 1);
	foreach ($distribution as $num => $value) {
		if ($num >= $passes) {
			//d($num, $value);
			$q += $value;
		} //else d($num, $passes, $value);
	}
	//d($q);
	$q *= $intervalData['days'];



	if ($stationsN) {
		//step: делим значение, на кол-во станций (ak simplest рапспределение по станциям)
		//d($q, $passes, $stationsN);
		$q = ceil($q / $stationsN);

	}

}

return $q;




