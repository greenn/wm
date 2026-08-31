<?
# after-time | cur | data
#
$Self = _rw::name('tool-log');
$_ctx = $Self::tempCtx(array(
	'time' => false,
	'tmp' => false,
	'filter' => false,
));

$tmp = $_ctx['tmp'];
$time = $_ctx['time'];
$filter = $_ctx['filter'];
//dx($tmp, $filter, $time);

if (!$tmp) $tmp = strtotime($time);

$updateTime = time();
$logData = log::getData($rid = false, 'html-only', $logData = true);
$resData = log::dataFilter($logData, $filter, $tmp);
//dx($resData);


return array(
	'list' => $resData,
	'updateTime' => $updateTime,
	//'request-headers' => getallheaders()
);