<?#3.14.2

class iqPro extends iqCore {

	var $selfDir; //ak selfDirPath
	var $dirSelf; //ak selfDirName
	//var $data;

	protected $directAssignProps = array('selfDir', 'selfDir');
	var $options = array();
	var $settings = array();



	function defaultConfig(){
		return array(
			'php' => true, //"$selfDir/iq/gss3.class.php"
			'req' => array(),
			'css' => true, //"$selfDir/css/gss3-css.php",

			'wdDir' => true, //"$selfDir/wd",
			'pagesDir' => true, //"$selfDir/pages"
			'routerDir' => true, //"$selfDir/router"
		);
	}

	function __construct($config){
		$this->initProperties($config);
		$this->verifySelfDir();

		$this->init_php();
		$this->init_css();

		$this->init_pages();
		$this->init_wd();
		//$this->init_pages();
		$this->init_router();

		$this->init_env();
	}

	function verifySelfDir(){
		///$this->dbg(array('$this->dirSelf' => $this->dirSelf), $this->dirSelf);
		$rootDir = $_SERVER['DOCUMENT_ROOT'];
		if (!$this->dirSelf) {
			$this->dirSelf = pathLess($this->selfDir, $rootDir);
			$this->dirSelf = trim($this->dirSelf, '/\\');
		} else if (!$this->selfDir) {
			$rootDir = $_SERVER['DOCUMENT_ROOT'];
			$this->selfDir = $rootDir.'/'.$this->dirSelf;
		}
	}


	function init_php() {
		_needphp(
				//'fq/_props',
			'prop.class',
			'fq/_is',
			'gt',
			'pathValue'
		);

		$sid = $this->opt('sid');
		$phpSubPath = $this->opt('php');
		//if ($phpSubPath === true) $phpSubPath = "iq/$sid.class.php";
		if ($phpSubPath === true) $phpSubPath = "php/$sid.env.php";

		$phpPath = "{$this->selfDir}/$phpSubPath";
		include_once $phpPath;
	}

	function init_css() {
		$sid = $this->opt('sid');
		$cssPath = $this->opt('css');
		//if ($cssSubPath === true) $cssSubPath = "iq/css/{$sid}-css.php";
		if ($cssPath === true) $cssPath = "css/{$sid}-css.php";

		if ($cssPath) {
			$cssPath = is_file($cssPath) ? $cssPath : "{$this->selfDir}/$cssPath";
			//dx($cssPath, is_file($cssPath), $cssPath);
			include_once $cssPath;
		}
	}

	var $wdDir;
	function init_wd() {
		$this->initPropPath('wdDir', 'wd');
	}

	var $pagesDir;
	function init_pages() {
		$this->initPropPath('pagesDir', 'pages');
	}

	var $routerDir;
	function init_router() {
		$this->initPropPath('routerDir', 'router');
	}

	var $env = array();

	function init_env(){
		$envList = $this->opt('env');
		if (!is_array($envList)) return;
		foreach ($envList as $envName => $env) {
			if (is_string($env)) $env = array('type' => 'call', 'caller' => $env);
			if (isOrdinal($env)) $env = array('type' => 'class', 'caller' => $env[0], 'cfg' => _prop($env, 1));

			$this->env[$envName] = new envCaller($env['caller'], $env['type'], _prop($env, 'cfg'));
		}

	}

	function hasEnv($envName){
		return _prop($this->env, $envName);
	}

	function callEnv($envName, $callArgs){

		return call_user_func_array($this->env[$envName], $callArgs);

		//$method = $callArgs[0];
		//$methodArgs = array_slice($callArgs, 1);
		//return call_user_func_array(array($envInstance, $method), $methodArgs);
	}

	function __call($mehod, $args){
		if ($this->hasEnv($mehod)) {
			return $this->callEnv($mehod, $args);
		}
	}

	function callArgs($args){
		if ($args) {
			$firstArg = $args[0];
			if ($this->hasEnv($firstArg)) {
				return $this->callEnv($firstArg, array_slice($args, 1));
			}
		}

		return parent::callArgs($args);
	}


	function run(){
		$pathRun = $this->opt('run');
		if ($pathRun === true) {
			$pathRun = "{$this->selfDir}/run.inc";
		}
		if (is_file($pathRun)) {
			include $pathRun;
		}
	}

}