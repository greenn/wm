<?#5.5.0 - site page (ak page data)
//объект данных страницы

_needphp('site/v2/page-propPik.trait');


class site_page {

	var $data = array();
	var $pid;


	var $proSid;
	var $pagesClass; //extends of _pages

	function __construct($data, $pid, $proSid = true) {
		$this->data = $data;
		$this->pid = $pid;
		$this->proSid = $proSid;
		$this->pagesClass = _proOptEnv($proSid, 'pages');
	}

	public function __invoke(...$args) {
		return $this->prop(...$args);
	}

	//получить срез из данных страницы
	function prop(...$name) {
		if (!$name) return $this->data;
		//dx($this->data, $name, getValueByPath($this->data, $name));
		return getValueByPath($this->data, $name);
	}

	function has_prop($name) { /*{s,oa}*/
		//dx($this->data, $name, isPathExists($this->data, $name));
		return isPathExists($this->data, $name);
	}

	function get_prop($name, $otherwise = null) {
		if ($this->has_prop($name)) {
			return $this->prop($name);
		}
		return $otherwise;
	}


	use page_propPik;

	function title($type = 'page', $alt = false, $def = 'page'){
		return $this->propPikIn('title', array($type, $alt, $def));
	}

	//получить конфигурацию ссылки
	function linkCfg($extend = false){
		$cfg = $this->prop('link');
		if (!is_array($cfg)) $cfg = array();

		if (is_array($extend)) {
			$cfg = array_merge($cfg, $extend);
		}

		$extUri = prop($cfg, 'external');
		if ($extUri) return $extUri;


		$baseUri = $this->prop(array('link', 'url'));
		if (!is_string($baseUri)) $baseUri = $this->pid;
		//hk
		if ($baseUri === data_opt('base_pid')) {
			$baseUri = "/";
		}

		$protocol = prop($cfg, 'protocol');
		if (!is_string($protocol)) {
			$protocol = hostProtocol;
			//$protocol = $protocol ? 'https://' : ($protocol === null ? '//' : 'http://');
		}

		$subDomain = prop($cfg, 'subDomain');
		//d($subDomain, $baseUri);
		$pidAsSubdomain = $subDomain === true;
		if ($pidAsSubdomain) $subDomain = $baseUri;
		//if (is_array($subDomain)) $subDomain = join('.', $subDomain); //01

		$domain = prop($cfg, 'domain');
		if (!is_string($domain)) $domain = site('hostName');
		//dx($domain, cur_iq('hostName'));

		if ($subDomain) $domain = "$subDomain.$domain";

		$uri = prop($cfg, 'uri', $pidAsSubdomain ? false : true);
		if ($uri === true) $uri = $baseUri;
		if ($uri) $uri = $this->pagesClass::getUriPid($uri, true);

		$subUri = prop($cfg, 'subUri');
		if ($subUri) $uri = $uri ? "$uri/$subUri" : $subUri;

		return "{$protocol}$domain/$uri";
	}

	function uri($linkCfg = false){
		if (!$linkCfg) $linkCfg = $this->prop('link');
		$uri = prop($linkCfg, 'external');
		if (!$uri) {
			$uri = prop($linkCfg, 'uri');
			if (!$uri) $uri = $this->pid;
			$uri = $this->pagesClass::getUriPid($uri, true); //check uriMap (iq/config/pages.inc)
		}
		return $uri;
	}

	function link($withDomain = false){
		$linkCfg = $this->has_prop('link') ? $this->prop('link') : true;
		$fullLink = $withDomain;

		$fullLink += has_prop($linkCfg, 'subdomain');

		if ($fullLink){
			$possibleCtx = $withDomain;
			$link = $this->linkCfg($possibleCtx);
			//dx($link);
		} else {
			//$uri = prop($linkCfg, 'uri', $this->pid);
			$uri = $this->uri($linkCfg);
			//hk
			if ($uri === pro('opt', 'base_pid')) {
				$link = "/";
			} else {
				$link = "/$uri";
			}
		}

		///$link .= '/'.join('/', $this->subPids);

		return $link;
	}

	function makeLink($subUri = '', $fullLink = false){
		$link = $this->link($fullLink);
		if ($subUri) {
			$link = rtrim($link, '/')."/$subUri";
		}
		return $link;
	}

}