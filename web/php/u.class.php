<?#0.18.1


class _u {

	static function gen_hash($data){
		return hash('adler32', join('/', $data));
	}

	static function agent_info($prop = false){
		$info = array(
			'browser' => $_SERVER['HTTP_USER_AGENT'],
			'ip' => $_SERVER['REMOTE_ADDR'],
			'sid' => s::data_get('u-info-sid', 0),
		);
		$info['hash'] = hash('adler32', join('/', array_values($info)));
		return $prop ? prop($info, $prop) : $info;
	}

}