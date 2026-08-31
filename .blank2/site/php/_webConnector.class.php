<?#2.5.6

function connect_web($config){
	$Web = new _webConnector($config);
	//dx($Web);
	//set_connected_web($Web);

	$WebConfig = $Web->getConfigProps(array(
		'hostName',
		'subDomain',

		'rootDir',
		'hostNames',
	));
	//dx($WebConfig);
	return $WebConfig;
}

//function set_connected_web(){}
//function get_connected_web(){}
//function connected_web(){}

class _webConnector {
	var $rootDir;
	var $configDir;

	protected $curHost;

	var $hostNames;
	var $hostName;
	var $subDomain;



	static function dbg($data, $raw = false, $exit = false) {
		echo '<pre>',
		$raw ? $data: var_export($data),
		'</pre>';
		if ($exit) exit;
	}

	static function dbgPath($path){
		return array(
			'path' => $path,
			'is_file' => is_file($path),
		);
	}


	function __construct($config) {

		$this->rootDir = $config['rootDir'] ?? true;
		if ($this->rootDir === true) $this->rootDir = $_SERVER['DOCUMENT_ROOT'];

		$this->configDir = $config['configDir'];


		$this->curHost = preg_replace('~^www\.~', '', $_SERVER['HTTP_HOST']);

		$this->hostNames = $config['hostNames'] ?? array(
			$this->curHost
		);

		$this->define_hostName();
		$this->connect_web();
		$this->connect_web_req();

		_needphp('str/startsWith');
		//dx(need::get_info());
	}

	function usePath($path){
		if (is_file($path)) {
			include_once $path;
		}
	}

	function define_hostName(){
		$subDomain = false;
		$matchHost = static::hostNameMatch($this->curHost, $this->hostNames);
		if (!$matchHost) {
			list($subDomain, $matchHost) = static::hostNameSubMatch($this->curHost, $this->hostNames);
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


	function connect_web(){
		$selfWeb = "{$this->configDir}/web/web[self].inc";
		$hostWeb = "{$this->configDir}/web/web[{$this->hostName}].inc";

		if (0) $this->dbg(array(
			'$hostName' => $this->hostName,
			'$selfWeb' => $this->dbgPath($selfWeb),
			'$hostWeb' => $this->dbgPath($hostWeb),
		), false, true);

		if (is_file($selfWeb)) {
			$this->usePath($selfWeb);
		} else if (is_file($hostWeb)) {
			$this->usePath($hostWeb);
		}
		//_needphp('notch'); _notch('iq');
	}

	function connect_web_req(){
		_needphp('pathValue'); //getValueByPath(); isPathExists()

		_needphp(
			'site/v2/iq'
		);

		_needphp(
			'site/v2/site_router.class',
			'site/v2/page_uri.class',
			'site/v2/site_page.class',
			///'site/v2/site_pid.class',

			'site/v2/_pages.class',
			'site/v2/_page.class',
			'site/v2/_img.class',
			'site/v2/_css.class',
			'site/v2/css-vars.class',
			//'site/v2/vue',

			'site/v2/source.class',
			'site/v2/r/rt.class',
			'site/v2/r/rb.class',
			'site/v2/r/lay.class'
		);
	}


	function getConfig(){
		//ak selfConfig
		$config = array(
			'rootDir' => $this->rootDir,
			'configDir' => $this->configDir,

			'hostNames' => $this->hostNames,

			'hostName' => $this->hostName,
			'subDomain' => $this->subDomain,
		);
		return $config;
	}

	function getConfigProp($prop){
		$config = $this->getConfig();
		return $config[$prop] ?? null;
	}

	function getConfigProps($props){
		$list = array();
		foreach ($props as $prop) {
			$list[$prop] = $this->getConfigProp($prop);
		}
		return $list;
	}

}