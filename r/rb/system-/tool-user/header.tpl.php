<?

$Self = self_rp();

$User = rp_user::$acc;

$userSecData = $User->__dbgData();
$userInfo = $userSecData['info'];
$userData = $userSecData['data'];


?>

<div>
    <b>UID:</b>
    <span><?=$userInfo['uid']?></span>
</div>

<div>
    <b>Тип:</b>
    <span><?=$userInfo['type']?></span>
</div>

<div>
    <b>Сессия:</b>
    <div><? d($User->s()) ?></div>
</div>
