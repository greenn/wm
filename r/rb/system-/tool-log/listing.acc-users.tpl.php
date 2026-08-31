<?

if ($uid = gt('login')) {
	$Acc = acc_users::get_user($uid);
	$Acc->login();
}
if ($uid = gt('logout')) {
	$Acc = acc_users::get_user($uid);
	$Acc->logout();
}



_needphp('url');

$Self = self_rp();

site_js::req_name('jquery');
site_js::req_name('lodash');
$Self::req_js('tool-log/listing');


$nTL = $Self::nc('tool-log');
$nTL_H = $Self::nc('tool-log-head');
$nTL_C = $Self::nc('tool-log-content');

$nTL_U = $Self::nc('tool-log-users');
$nTL_S = $Self::nc('tool-log-sessions');
$nTL_R = $Self::nc('tool-log-requests');

$_ctx = $Self::tplCtx(array(
	'uid' => false,
	'sid' => false,
	'rid' => false,
	'filter' => false,
)); //dx($_ctx);

$_uid = $_ctx['uid'];
$_sid = $_ctx['sid'];
$_rid = $_ctx['rid'];
$_filter = $_ctx['filter'];
$_filter = (is_string($_filter) && $_filter) ? explode(',', $_filter) : array();

//dx($_uid, $_sid, $_rid);

$pr = $Self::relPath(__FILE__);
$ur = pagePath;

//dx(11);
$userList = array();
$Acc = cur_user();
$users = acc_users::__info();


//dx($users);
foreach ($users as $uid => $info) {
	$item = array('uid' => $uid);
	$item['sids'] = array_keys($info['sessions']);
	$item['sids'] = array_reverse($item['sids']);
	$item['ips'] = array_keys($info['ip']);
	$item['ips'] = array_reverse($item['ips']);
	$item['isCur'] = $Acc->uid === $uid;
	$item['link'] = url_set($ur, array('uid' => $uid));
	if (!isset($info['type'])) d($uid, $info);
	$item['type'] = $info['type'];
	$item['date-create'] = $info['create_date'];

	$item['login'] = false;
	$item['name'] = false;
	$item['isLoggedIn'] = false;
	if ($info['type'] === 'basic') {
		$Acc = acc_users::get_user($uid);
		$item['login'] = $info['login'];
		$item['name'] = $Acc->name();
		$item['is-logged'] = $Acc->isLoggedIn();
    }

	$item['link-login'] = url_set($ur, array('login' => $uid));
	$item['link-logout'] = url_set($ur, array('logout' => $uid));

	$userList[$uid] = $item;
}

//step: сортируем пользователей по типу
$basicUsers = array();
$demoUsers = array();
foreach ($userList as $uid => $info) {
    if ($info['type'] === 'basic') {
	    $basicUsers[$uid] = $info;
    } else {
	    $demoUsers[$uid] = $info;
    }
}

//сортировка по ключу в значении
//https://stackoverflow.com/questions/1597736/how-to-sort-an-array-of-associative-arrays-by-value-of-a-given-key-in-php
$_dates = array();
foreach ($demoUsers as $uid => $info){
	$_dates[$uid] = $info['date-create'];
}
//SORT_DESC - сначала новые
array_multisort($_dates, SORT_DESC, $demoUsers);



$userList = array_merge($basicUsers, $demoUsers);

//dx($userList, $users);

$userData = null;
$sessionData = array();
//$requestsData = array();
$logData = array();

if ($_uid) {
	//dx($userList[$uid], $users[$uid]);
	$userData = $userList[$_uid];

    $curSid = session_id();
	$userData['sessionsInfo'] = array();
	foreach ($userData['sids'] as $sid) {
		$sessionList = $Self::getSessionLogBySid($sid, false, false);
		$sessionsKeys = $sessionList ? array_keys($sessionList) : array();
		//dx($sessionsKeys, $sessionList, $userData);

		$ridsDate = array();
		if ($sessionsKeys) {
			foreach ($sessionsKeys as $rid) {
				$ridsDate[$rid] = date('H:i:s m/d', floor($rid));
			}
        }

        $lastDate = $sessionsKeys ? end($sessionsKeys) : false;
		//$sessionIndex = $lastDate ? "$lastDate-$sid" : $sid;

		$userData['sessionsInfo'][$sid] = array(
            'sid' => $sid,
            'lastDate' => $lastDate,
            'ridsDate' => $ridsDate,
            'data' => $sessionList,
            'link' => url_set($userData['link'], array('sid' => $sid)),
            'isCur' => $sid === $curSid
        );
    }

	uasort($userData['sessionsInfo'], 'rp_system::sortByLastDateDesc_cb');


	if ($_sid) {
		$sessionData = array();
	    //d($userData);
		//$sessionList = $Self::getSessionLogBySid($_sid, false, 'html');
		//foreach ($sessionList as $rid => $data) {}
		//dpx($_sid, $sessionList);

		$sessionData = $userData['sessionsInfo'][$_sid];
		//dx($sessionData);

		if ($_rid) {
		    //dx($_rid, $sessionData);
			//$_rid = (float) $_rid;
			//dx($_rid, $sessionData['data']);
			$logData = $Self::getSessionLog($_rid, 'html', $sessionData['data']);

			//dpx($_rid, $logData);
		}
	}


}





?>
<section class="<?=$nTL?>">
	<div class="<?=$nTL_H?>">

		<div class="_col <?=$nTL_U?>">
            <div class="col-w">
                <h3>Users</h3>
                <ul>
                    <? foreach ($userList as $uid => $user) {
                        $ncSelected = $uid === $_uid ? '-selected' : '';
                        //d($user);
                        $userName = $uid;
                        $userTitle = $user['date-create'];
                        $cmdLink = false;
                        $cmdText = false;
	                    if ($user['type'] === 'basic') {
		                    $userName = $user['name'];
		                    $userTitle = $user['login'];

		                    $cmdText = 'login as';
		                    $cmdLink = $user['link-login'];
		                    if ($user['is-logged']) {
			                    $cmdText = 'logout';
			                    $cmdLink = $user['link-logout'];
                            }

                        }
                    ?>
                        <li class="<?=$nTL_U?>-item <?=$ncSelected?>">
	                        <? if ($cmdLink) { ?><a href="<?=$cmdLink?>"><?=$cmdText?></a><? } ?>
                            <a class="<?=$nTL_U?>-link" href="<?=$user['link']?>" title="<?=$userTitle?>"><?=$userName?></a>
                            <? if ($user['isCur']) { ?><span title="Current user" class="ch">*</span><? } ?>
                            <span>(<?=join(', ', $user['ips'])?>)</span>
                        </li>
                    <? } ?>
                </ul>
            </div>
		</div>

		<? if ($userData) { ?>
		<div class="_col <?=$nTL_S?>">
            <div class="col-w">
                <h2>User: <i><?=$userData['uid']?></i></h2>
                <h3>Sessions</h3>
                <ul>
                    <? foreach ($userData['sessionsInfo'] as $sIndex => $session) {
                        $sid = $session['sid'];
		                //$title = join(';'.ARN, array_values($session['ridsDate']));
		                $title = $session['lastDate'] ? date('Y/m/d H:i:s', $session['lastDate']).' (last-access)' : 'no-last-date';
		                $qRids = count($session['ridsDate']);
		                $ncSelected = $sid === $_sid ? '-selected' : '';
                    ?>
                        <li class="nobr <?=$nTL_S?>-item <?=$ncSelected?>">
                            <span>(<?=$qRids?>)</span>
                            <a href="<?=$session['link']?>" title="<?=$title?>">
				                <?=$sid?>
                            </a>
			                <? if ($session['isCur']) { ?><span title="Current session" class="ch">*</span><? } ?>
                        </li>
	                <? } ?>
                </ul>
            </div>
		</div>
		<? } ?>

		<? if ($sessionData) { ?>
			<div class="_col <?=$nTL_R?>">
                <div class="col-w">
                    <h2>Session: <i><?=$_sid?></i></h2>
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