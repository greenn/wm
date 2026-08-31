<?#3.3.1 - page data

need::pro('page-propPik.trait');

class page {
	var $pid = '';
	var $subPids = array();
	var $data = array();
	function __construct($data, $pid) {
		$this->data = $data;
		if (is_array($pid)) {
			$this->pid = array_shift($pid);
			$this->subPids = $pid;
		} else if ($pid instanceof pid) {
			dx($pid);
			//$this->pid =
			//$this->subPids =
			//$this->data +=
		} else {
			$this->pid = $pid;
		}

	}

	function has_prop($name) { /*{s,oa}*/
		//d('has_prop', $this->data, $name);
		return call_user_func('_page::has_slice', $this->data, $name);
		//_page::has_slice();
	}

	//получить срез из данных страницы
	function prop($name /*{s,oa}*/, $otherwise = null) {
		$args = (array)$name;
		if ($this->has_prop($name)) {
			array_unshift($args, $this->data);
			return call_user_func_array('_page::slice', $args);
		}
		return $otherwise;
	}

	use page_propPik;

	function title($type, $alt = false, $def = 'page'){
		return $this->propPikIn('title', array($type, $alt, $def));
	}

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
		if ($baseUri === pro('opt', 'base_pid')) {
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
		if (!is_string($domain)) $domain = cur_iq('hostName');
		//dx($domain, cur_iq('hostName'));

		if ($subDomain) $domain = "$subDomain.$domain";

		$uri = prop($cfg, 'uri', $pidAsSubdomain ? false : true);
		if ($uri === true) $uri = $baseUri;
		if ($uri) $uri = _page::getUriPid($uri, true);

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
			$uri = _page::getUriPid($uri, true); //check uriMap (iq/config/pages.inc)
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

		if ($this->subPids) {
			$link .= '/'.join('/', $this->subPids);
			//todo get SubPidsUriByModConfig
		}

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