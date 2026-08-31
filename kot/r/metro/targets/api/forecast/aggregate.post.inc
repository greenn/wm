<?

$Self = _kot::self();

include_once $Self::path($Self::relDir("aggregate.class.inc"));

$_ctx = $Self::tempCtx(array(
	'targets' => array(),
));
//d($_ctx);


$targetsList = $_ctx['targets'];
//dx($targetsList);

$aggregateList = array();
$resList = array();
$dbgList = array();

foreach ($targetsList as $targetData) {
	$targetName = $targetData['name'];
	///$targetName = prop($targetData, 'name', 'passes/passes-qy');
	$names = explode('/', $targetName);
	$type = $names[0];
	$relPath = $Self::relDir("aggregate/$type");
	$hasCalcHandler = is_file($Self::path("$relPath.inc"));

	if (isLocalhost && $hasCalcHandler) { $res = $Self::call($relPath, $targetData); } else
	//case: нет хендлера - выбираем random-число, близко к 10000
	$res = targets_aggregate::randomNear(10000, targets_aggregate::$curCoverage);


	$dbgList []= array('targetName' => $targetName, 'type' => $type, 'hasCalcHandler' => $hasCalcHandler, 'coverageRes' => $res, 'ctx' => $targetData);
	$resList []= $res;
	if (!isset($aggregateList[$type])) $aggregateList[$type] = array();
	$aggregateList[$type] []= targets_aggregate::prepare($targetName, $targetData);
}

//step: просто находим ариф. среднее (ak simplest-пересечение)
$coverage = ceil(array_sum($resList) / (count($resList) || 1));



return kot_api::response(array(
	'coverage' => $coverage,
	'clickhouseRequest' => $aggregateList, //данные для запроса в click-house
	'dbg' => 'dbgList;',
	'dbgList' => $dbgList,
));
