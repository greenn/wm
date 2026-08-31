<?#3.0.1

class _iq {
	static $web = array();

	static $siteCur;
	static function set_cur_site($siteSid){
		static::$siteCur = $siteSid;
	}
	static $site = array(
		# $siteSite => instance of iqSite (iq-site.class)
	);
	static function add_site($siteSid, $cfg, $setCur = false) {
		$cfg = array('sid' => $siteSid) + $cfg;
		$siteIq = new iqSite($cfg);
		static::$site[$siteSid] = $siteIq;
		if ($setCur) static::set_cur_site($siteSid);
	}
	

	static $proCur;
	static function set_cur_pro($proSid){
		static::$proCur = $proSid;
	}
	static $pro = array(
		# $proSid => instance of iqPro (iq-pro.class)
	);
	static function add_pro($proSid, $cfg, $setCur = false) {
		$cfg = array('sid' => $proSid) + $cfg;
		$proIq = new iqPro($cfg);
		static::$pro[$proSid] = $proIq;
		if ($setCur) static::set_cur_pro($proSid);
	}

	//выполнение
	static function call_siteArgs($siteSid = true, $callArgs = array()){
		//dx('call_siteArgs', $siteSid, $callArgs);
		if ($siteSid === true) $siteSid = static::$siteCur;
		//dx('call_siteArgs', $siteSid, isset(static::$site[$siteSid]));
		if (isset(static::$site[$siteSid])) {
			$Site = static::$site[$siteSid];
			return $Site->callArgs($callArgs);
		} else {
			//dx($siteSid, static::$site[$siteSid]);
		}
		//return 15;
		return null;
	}

	static function call_proArgs($proSid = true, $callArgs = array()){
		if ($proSid === true) $proSid = static::$proCur;
		if (isset(static::$pro[$proSid])) {
			$Pro = static::$pro[$proSid];
			//dx($proSid, $callArgs);
			return $Pro->callArgs($callArgs);
		}
		return null;
	}
}

