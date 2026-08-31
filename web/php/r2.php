<?//3-12
_needphp('fileUrl', 'j');

define('rDir', 'r');
define('yDir', 'y');
define('R_BASE', 'base');
define('R_RELATIVE', 'relative');


function r(){
	$args = func_get_args();
	$R = new ReflectionClass('R');
	$R = $R->newInstanceArgs($args);
	return $R;
}

function ry(){
	$args = func_get_args();
	$args []= array('y' => true);
	$R = new ReflectionClass('R');
	$R = $R->newInstanceArgs($args);
	return $R;
}


class R {
	private $pathPattern;
	function setPattern(){
		$pattern = ROOTs.rDir.'/%s';

		if (osLinux) {
			$pattern = preg_quote(str_replace('\\', '/', $pattern));
			if ($this->opt('base')) {
				$pattern = sprintf($pattern, '([^/]+)/'); # начальный cmpt
				# $pattern = sprintf($pattern, '([^/]+)/?');
			}
			if ($this->opt('relative')) {
				$pattern = sprintf($pattern, '(.+)/.*$'); # относительный cmpt
				# $pattern = sprintf($pattern, '(.+)/?.*$');
			}

		}
		if (osWindows) { # https://regex101.com/r/hoXPcV/2
			$pattern = preg_quote(str_replace('/', '\\', $pattern));
			if ($this->opt('base')) {
				$pattern = sprintf($pattern, '([^\\\\]+)\\\\'); # начальный cmpt
				# $pattern = sprintf($pattern, '([^\\\\]+)\\\\?');
			}
			if ($this->opt('relative')) {
				$pattern = sprintf($pattern, '(.+)\\\\.*$'); # относительный cmpt
				# $pattern = sprintf($pattern, '(.+)\\\\?.*$');
			}


		}

		$this->pathPattern = $pattern;
	}

	var $options = array(
		'relative' => true
	);

	function opt($name){
		return isset($this->options[$name]) && $this->options[$name];
	}

	function handleOptions($optionsStack){
		$this->applyOptions($optionsStack);
		//$this->setRDir();
	}
	//Добавление настроек в стек-настроек ($this->options)
	function applyOptions($stack){
		$optConf = array(
			array(R_BASE, R_RELATIVE)
		);
		foreach ($stack as $option) {
			foreach ($optConf as $conf) {

				if (is_stringable($conf) && in_array($option, $conf)) {
					foreach ($conf as $name) {
						$this->options[$name] = $option == $name;
					}
				}

				if (is_array($conf)) {
					$this->options = array_replace($this->options, $conf);
				}
			}
		}
		//dx($this->options);
	}

	//private $rDir;
	//function rDir(){ return $this->opt('rDir'); prop($this->options, 'rDir'); }
	function setRDir($set = false){
		if (!$set) $set = $this->options;

		$this->rDir = rDir;
		if ($rDir = prop($set, 'rDir')) {
			$this->rDir = $rDir;
		}
		if (prop($set, 'y') === true) {
			$this->rDir = yDir;
		}
	}

	function __construct($filePath = false/*, options, ...*/){

		if (!$filePath) {
			$filePath = getCaller('path'); //getCaller('path', 'r')
		}

		if (func_num_args() > 1) {
			$options = func_get_args();
			array_shift($options);
			$this->applyOptions($options);
		}

		$this->locate($filePath);
	}




	var $name;
	var $rName;
	var $jn;
	var $dir;
	var $uri;
	var $url;

	private function setName($name){

		$this->name = $name;
		$this->rName = rDir.'/'.$name;
		//$this->jn = "r::{$name}";
		$this->jn = "root::{$this->rName}";
		$this->dir = ROOTs.rDir.'/'.$name;
		$this->uri = fileUrl($this->dir);
		$this->url = hostUrl.$this->uri;
	} 
	function locate($filePoint){
		//d($filePoint, realpath($filePoint), !is_file($filePoint), !is_dir($filePoint), !is_file($filePoint) || !is_dir($filePoint));
		if (!is_file($filePoint) && !is_dir($filePoint)) {
			$filePoint = ROOT.'/'.rDir.'/'.trim($filePoint, '/');
		}
		$filePoint = realpath($filePoint);
		if (is_dir($filePoint)) $filePoint .= DIRECTORY_SEPARATOR;
		//if (!$filePoint) return;

		if (!$this->pathPattern) $this->setPattern();

		$name = $this->get_name($filePoint);

		if ($name) {
			$this->setName($name);
		}
	}

	function parse_name($conf){
		$name = null;
		if ($rName = prop($conf, 'r')) {
			$rPath = ROOTs.rDir."/$rName";
			if (is_dir($rPath)) {
				$name = $rName;
			}
		}
		return $name;
	}
	function get_name($path){
		$name = null;
		if (is_array($path)) return $this->parse_name($path);
		
		if (preg_match("~^{$this->pathPattern}~", $path, $matches)) {
			$name = str_replace('\\', '/', $matches[1]);
		}
		//d($name, $path, $this->pathPattern, $matches);
		return $name;
	}

	function __call($name, $arguments){
		if (isset($this->{$name})) {
			$addToName = isset($arguments[0]) ? $arguments[0] : false;
			return $addToName ? "{$this->{$name}}/$addToName" : $this->{$name};
		}
	}

	function __get($name){
		$value = null;
		switch ($name) {
			case 'rDir': $value = prop($this->options, 'rDir'); break;
		}
		return $value;
	}

	function __set($name, $value){
		switch ($name) {
			//case 'rDir': $this->options[$name] = $value; break;
		}
		return $value;
	}

	function req($subPath){
		$path = $this->dir($subPath);
		if (is_file($path)) require_once ($path);
	}

	/*function jd(){
		$args = func_get_args();
		array_unshift($args, $this->jName);
		return call_user_func_array('jd', $args);
	}*/

	function jd(){
		$args = func_get_args();

		$jn = $this->jn(ltrim(array_shift($args), '/'));
		//d($jn, $args);
		array_unshift($args, $jn);
		//d($args);
		return call_user_func_array('jd', $args);
	}
	function jdsn(){
		$args = func_get_args();
		$jn = $this->jn(array_shift($args));
		array_unshift($args, $jn);
		//d($args);
		return call_user_func_array('jdsn', $args);
	}



	/*function relUrl(){
		_needphp('gt/ref');

		dn(
			refPath,
			$_SERVER['HTTP_REFERER'],
			$this->dir,
			fileUrl($this->dir),
			$this->uri
		);
	}*/
}

//resocurce class
class RC {

}