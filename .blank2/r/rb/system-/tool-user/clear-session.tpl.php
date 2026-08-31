<?
_needphp('redirect');

$Self = self_rp();

if (gi_key(0) === 'clear-session') {
    //dx('rebuild-sesssion');
	session_regenerate_id(FALSE);
	session_unset();
	redirect(pagePath);
}

//$User = rp_user::$acc;
?>

<a href="<?=pagePath?>?clear-session"><button>clear session</button></a>
