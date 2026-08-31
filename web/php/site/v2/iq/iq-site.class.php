<?#3.10.0

class iqSite extends iqCore {

	var $rootDir;
	var $selfDir;


	var $options = array();
	var $settings = array();
	protected $directAssignProps = array('selfDir', 'hostName');

	function defaultConfig(){
		return array(
			'selfDir' => true,
			'pagesDir' => true,
			'routerFile' => true,
			'uv' => true,
			'rMain' => 'site',
		);
	}

	function __construct($config){
		$this->rootDir = $_SERVER['DOCUMENT_ROOT'];

		$this->initProperties($config);

		//ak $this->initSelfDir();
		///$this->dbg(array('$config' => $config), $config);
		if ($this->selfDir === true) {
			$this->selfDir = "{$this->rootDir}/site";
		}



		$this->connect_settings();
		$this->run_domains();

		$this->init_router();

		$this->init_db();

		$this->init_uv();

	}


	function connect_settings(){
		$pathSettings = "{$this->selfDir}/settings/settings.inc";
		$this->useSettingsPath($pathSettings);

		$hostName = $this->hostName;
		$hostSettings = "{$this->selfDir}/settings/settings[$hostName].inc";
		$this->useSettingsPath($hostSettings);
	}

	function run_domains(){
		$pathDomains = "{$this->selfDir}/domains.inc";
		if (is_file($pathDomains)) {
			include $pathDomains;
		}
	}

	//init_need  php/pro/pro.class.php:124



	var $routerFile;
	function init_router() {
		$this->initPropPath('routerFile', 'router.php');
	}

	function init_uv(){
		$uv = $this->opt('uv');

		if ($uv) {
				//php/pro/pro.class.php:132
			_needphp('uv');
				//web/inc/uv/urlVersion.php:360
				//подключается web/inc/uv/sd/web.uv

			$sid = $this->opt('sid');
			$uvPath = "{$this->selfDir}/uv/{$sid}[{$this->hostName}].uv";
			urlVersion::db_connect($uvPath);
			//dx(urlVersion::$db_path);

		}
	}


	function init_db(){
		//dx($this->settings);
		//dx($this->options);
		//db_name  php/pro/pro.class.php:86
		//db_struct  php/pro/pro.class.php:111
		//init_db  php/pro/pro.class.php:170

	}


	/*function callArgs($args){
		$firstArg = $args ? $args[0] : false;
		switch ($firstArg) {
			default: {
				//dx($firstArg);
				return parent::callArgs($args);
			}
		}
	}*/

}