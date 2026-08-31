<?
_needphp('url');

$Self = self_rp();

site_js::req_name('jquery');
site_js::req_name('lodash');
$Self::req_js('tool-log/listing');


$nTL = $Self::nc('tool-log');
$nTL_H = $Self::nc('tool-log-head');
$nTL_C = $Self::nc('tool-log-content');

$nTL_R = $Self::nc('tool-log-requests');

$_ctx = $Self::tplCtx(array(
	'rid' => false,
	'filter' => false,
)); //dx($_ctx);

$sid = session_id();

$_rid = $_ctx['rid'];
$_filter = $_ctx['filter'];
$_filter = (is_string($_filter) && $_filter) ? explode(',', $_filter) : array();

//dx($_uid, $sid, $_rid);

$pr = $Self::relPath(__FILE__);
$ur = pagePath;

//Обрабатываем данные сессии (текущей)
    $sessionLog = $Self::getSessionLogBySid($sid, false, false);
    $sessionsKeys = $sessionLog ? array_keys($sessionLog) : array();
    //dx($sessionsKeys, $sessionLog, $userData);

    $ridsDate = array();
    if ($sessionsKeys) {
        foreach ($sessionsKeys as $rid) {
            $ridsDate[$rid] = date('H:i:s m/d', floor($rid));
        }
    }

    $lastDate = $sessionsKeys ? end($sessionsKeys) : false;
    //$sessionIndex = $lastDate ? "$lastDate-$sid" : $sid;

    $sessionData = array(
        'sid' => $sid,
        'lastDate' => $lastDate,
        'ridsDate' => $ridsDate,
        'data' => $sessionLog,
        'link' => url_set(pagePath, array('sid' => $sid)),
        'isCur' => true
    );



$logData = array();

//dx(s(SYSLOG_NS));
if ($_rid) {
	//dx($_rid, $sessionData);
	//$_rid = (float) $_rid;
	//dx($_rid, $sessionData['data']);
	$logData = $Self::getSessionLog($_rid, 'html', true);

	//dpx($_rid, $logData);
}

?>
<section class="<?=$nTL?>">
	<div class="<?=$nTL_H?>">

		<? if ($sessionData) { ?>
			<div class="_col <?=$nTL_R?>">
                <div class="col-w">
                    <h2>Session: <i><?=$sid?></i></h2>
                    <h3>Requests</h3>
                    <ul>
                        <? foreach (array_reverse($sessionData['ridsDate'], true) as $rid => $date) {
                            $link = url_set($sessionData['link'], array('rid' => $rid));
                            $title = date('m/d H:i:s', $rid);
	                        $ncSelected = $rid === $_rid ? '-selected' : '';
                        ?>
                            <li class="<?=$nTL_R?>-item <?=$ncSelected?>">
                                <span><?=$title?></span>
                                <a href="<?=$link?>">
	                                <?=$sessionData['data'][$rid]['uri']?>
                                </a>
                            </li>
                        <? } ?>
                    </ul>
                </div>
			</div>
		<? } ?>

	</div>

	<? if ($logData) { //dpx($logData) ?>

        <div class="<?=$nTL_C?>">

            <?=$Self::tpl("$pr/filter", array('filter' => $_filter))?>
            <h2><?=date('Y-m-d H:i:s', $_rid)?> / <small><?=$_rid?></small></h2>

            <h3><?=$logData['uri']?></h3>
	        <? foreach ($logData['items'] as $index => $item) {
		        $type = $item['type'];

		        //dpx($_filter, !!$_filter);
		        if ($_filter && !in_array($type, $_filter)) continue;

		        $ncType = "-$type";
            ?>
                <i style="font-family: monospace; "><?=$item['line']?></i>
                <h3 class="<?=$ncType?>"><?=$item['msg']?></h3>
                <div><?=$item['ctx']?></div>
	        <? } ?>

        </div>

	<? } ?>

</section>