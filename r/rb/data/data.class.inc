<?
_needphp('dirToArray.class');
_needphp('fq/arr/defaultsDeep');

_rb::reg('data', array(
	'nc' => array(
		'base' => 'D'
	),
));

class rb_data extends rb {

	static function getItemProp($idnData, $prop = false){
		list($idn, $set) = $idnData;
		$itemData = static::getCacheItem($idn, $set);
		return $prop ? _prop($itemData, $prop) : $itemData;
	}

	static function getCacheItem($idn, $set){
		$R = _prop($set, 'R');
		$cacheId = join('/', array(
			$R::cfg('className'),
			$R::cfg('rName'),
			$idn
		));
		static $cache = array();
		if (!isset($cache[$cacheId])) {
			$cache[$idn] = static::getItem($idn, $set);
		}
		return $cache[$idn];
	}

	static function getItem($idn, $set){ //getItemData
		$R = _prop($set, 'R');
		$itemDir = _prop($set, 'dir');
		$itemPath = "$itemDir/$idn.data";
		//$ctx = _prop($set, 'ctx');
		//$ctx = _prop($set, array('ctx', $idn));
		//d($idn, $itemPath, $R::path($itemPath));
		$itemData = $R::call($itemPath, array());
		return $itemData;
	}


	static function getDirItems($set){ //getDirItemsData
		$list = array();

		$R = _prop($set, 'R');

		$dirCxt = defaultsDeep(
			_prop($set, 'dir-ctx'),
			array(
				'path' => $R::path(_prop($set, 'dir')),
				'keepDots' => false,
				'depth' => 0,
			)
		);

		$fileList = dirToArray::apply($dirCxt);
		//dx($fileList, $path, $pathName);
		$fileList = dirToArray::filterByExt($fileList, 'data.inc');
		$fileList = dirToArray::excludePath($fileList, array(
			'endsWith' => '-',
			'startsWith' => '-',
		));

		foreach (array_keys($fileList) as $filename) {
			$idn = basename($filename, '.data.inc');
			$list[$idn] =  static::getCacheItem($idn, $set);
		}
		//dx($list);
		return $list;
	}

}
