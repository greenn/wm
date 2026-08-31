<?#2.2.5

class siteIq {

	var $dirRoot;
	var $hostNames;
	var $hostName;
	var $subDomain;
	var $settings = array();

	function __construct($cfg){
		$this->dirRoot = $_SERVER['DOCUMENT_ROOT'];
		$this->hostNames = $cfg['hostNames'];

		$this->define_hostName();
		$this->connect_web();
		$this->connect_settings();
	}

	static function dbg($data, $exit = true, $raw = false) {
		echo '<pre>',
		$raw ? $data: var_export($data),
		'</pre>';
		if ($exit) exit;
	}

	static function dbgPath($path, $exit = true){
		static::dbg($path, array(
			'path' => $path,
			'is_file' => is_file($path),
		), $exit);
	}

	function define_hostName(){

		$curHost = $_SERVER['HTTP_HOST'];
		$subDomain = false;
		$matchHost = static::hostNameMatch($curHost, $this->hostNames);
		if (!$matchHost) {
			list($subDomain, $matchHost) = static::hostNameSubMatch($curHost, $this->hostNames);
		}
		$this->hostName = $matchHost;
		$this->subDomain = $subDomain;
	}

		static function hostNameMatch($curHost, $domains){
			foreach ($domains as $domain) {
				if ($curHost === $domain) {
					return $domain;
				}
			}
			return null;
		}
		static function hostNameSubMatch($curHost, $domains){

			usort($domains, function ($a, $b) {
				return strlen($b) - strlen($a); // Сортируем по длине в убывающем порядке
			});

			foreach ($domains as $domain) {
				if (substr($curHost, -strlen($domain)) === $domain) {
					$matchHost = $domain;
					break;
				}
			}

			if ($matchHost) {
				$subDomain = substr($curHost, 0, -strlen(".$matchHost"));
			} else {
				$subDomain = $curHost; // Если совпадений нет, берём весь хост
			}

			return array($subDomain, $matchHost);
		}

	function updateSettings($data){
		$this->settings = array_replace($this->settings, $data);
	}
	function useSettingsPath($path){
		if (is_file($path)) {
			$data = include $path;
			if ($data) {
				$this->updateSettings($data);
			}
		}
	}


	function connect_settings(){
		$root = $this->dirRoot;
		$pathSettings = "$root/site/settings/settings.inc";
		$this->useSettingsPath($pathSettings);

		$hostName = $this->hostName;
		$hostSettings = "$root/site/settings/settings[$hostName].inc";
		$this->useSettingsPath($hostSettings);
	}



			function run_domains(){
				$root = $this->dirRoot;
				$pathDomains = "$root/site/domains.inc";
				if (is_file($pathDomains)) {
					include $pathDomains;
				}
			}

}