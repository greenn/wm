<?
_site::reg('menu', array(
	'className' => 'site_menu',
	'nc' => array(
		'base' => 'M'
	),
));

//dx(cur_iq('hostName'));

class site_menu extends site {
	//static $qp = array('top-menu.css.php');

	static function nolinkUri($str = ''){
		return URI.'#'.$str;
	}

	//составить элемент для pid
	static function getItemCtx($pid, $menuName = false){
		$item = array(
			'pid' => $pid
		);
		//d($pid, _page::hasPid($pid));
		if (_page::hasPid($pid)) {
			$item['text'] = _prop::pikIn(_page($pid), 'title', array("$menuName-html", $menuName, 'menu-html', 'menu', 'page'));
			$item['link'] = page($pid, 'link', true);
		} else {
			static $noPidFlag = '?';
			$item['text'] = "{$noPidFlag}$pid";
			$item['link'] = static::nolinkUri($pid);
		}
		return $item;
	}

	//получить список элементов по api-запросу
	static function getMenuData($menuName, $ctx = array()){
		$list = static::call("data/$menuName.data", $ctx);

		return static::buildMenuData($list, $menuName);
	}

	//собрать элементы по api-данными
	static function buildMenuData($list, $menuName = false){
		$data = array();
		foreach ($list as $cfg) {
			$item = array();
			if ($pid = prop($cfg, 'pid')) {
				$item = static::getItemCtx($pid, $menuName);
			} else {
				dx('undeclared menu structure', $cfg);
			}
			$data []= $item;
		}
		return $data;
	}

	//static $fullLink = true;
	static function itemLink($pid, $subUri = '', $fullLink = true){
		return page($pid, 'makeLink', $subUri, $fullLink); //iq/php/page.class.php:140
	}
}