<?#3.0.0 - page-content

_needphp('fq/arr/defaultsDeep');
_needphp('isAssoc');

_rb::reg('page-content', array(
	'className' => 'rb_page_content'
));

class rb_page_content extends rb {

	//собираем (набираем) контент-конфиги в contents
	static function handleContentsCtx($ctx){
		$resultCtx = array(); //сюда переособираем конфиг

		$contents = array();
		if (isset($ctx['contents'])) {
			$contents = $ctx['contents'];
			unset($ctx['contents']);
			if (!is_array($contents)) {
				$contents = array();
			}
		}
		
		//ищем конфиги для 'content'
		$contentItem = false;
		if (isset($ctx['content'])) {
			$content = $ctx['content'];
			unset($ctx['content']);
			if ($content) {
				if (is_array($content)) {
					$contentItem = $content;
				} else {
					$contentItem = array('content' => $content);
				}
			}
		}

		if (isset($ctx['content-tpl'])) {
			$contentTpl = $ctx['content-tpl'];
			unset($ctx['content-tpl']);
			if ($contentTpl) {
				$contentItem = array(
					'content-tpl' => $contentTpl,
				);
			}

		}

		if ($contentItem) {
			$contents []= static::handleContentsItemCtx($contentItem, $ctx);
		}

		$resultCtx['contents'] = $contents;
		$resultCtx += $ctx;
		//dx($resultCtx);

		return $resultCtx;
	}

	static function handleContentsItemCtx($contentItem, &$ctx = false){
		$contentTpl = _prop($contentItem, 'content-tpl');
		if ($contentTpl === 'uc') {
			$contentItem['content-tpl'] = array('uc', 'content');
		}
		return $contentItem;
	}


	static function applyContentsCtx($ctx, $applyContentMethod = true){
		$contentsList = prop($ctx, 'contents');
		$contents = static::handleContents($contentsList, $applyContentMethod, $ctx);
		return join(newline2, $contents);
	}

	static $defApplyContentMethod = 'static::applyContentCtx';
		//'content' ~ string
		//'content-tpl' ~ ::applyContentTpl()

	//обработать ao-массив из content-cfg
	static function handleContents($contentsList, $applyContentMethod = true, $globalCtx = array()){
		if ($applyContentMethod === true) $applyContentMethod = static::$defApplyContentMethod;


		$contents = array();
		if (is_array($contentsList)) {
			foreach ($contentsList as $contentCtx) {
				//dx($contentCtx, is_callable($applyContentMethod));

				if (is_callable($applyContentMethod)) {
					$content = call_user_func($applyContentMethod, $contentCtx + $globalCtx);
					if (0) static::applyContentCtx();
					$contents []= $content;
				}
			}
		}
		return $contents;
	}


	static function applyContentCtx($contentCtx, $defRName = 'site'){
		//dx($contentCtx, prop($contentCtx, 'content-tpl'), $defRName);
		//dx($contentCtx, isOrdinal($contentCtx), $contentTpl = prop($contentCtx, 'content-tpl'));
		if (isOrdinal($contentCtx)) {
			$content = static::applyContentTpl($contentCtx, $defRName);
		}

		/*qq - кто юзает
			видимо много кто, у старницы конфиг > 'content-tpl' => array('contacts', 'content-contacts')
			и ещё это типо настройки для контента плана
				array(
					'content-title' => '',
					'content-tpl' => array('contacts', 'content-contacts')
				)
		*/
		else if ($contentTpl = prop($contentCtx, 'content-tpl')) {
			$content = static::applyContentTpl($contentTpl, $defRName);
			//dx($content, $contentTpl, $defRName);
		} else {
			$content = prop($contentCtx, 'content');
		}
		return $content;
	}

	static function applyContentTpl($tplCtx, $defRName = 'site'){
		if (count($tplCtx) === 4) {
			$rName = array_shift($tplCtx);
			//dx($rName, $contentTpl);
		} else {
			$rName = $defRName;
		}
		$content = _r_tpl($rName, $tplCtx);
		//d($content, $rName, $tplCtx);
		return $content;
	}

	static function applyContent($contentCfg, $applyContentMethod = true){
		if ($applyContentMethod === true) $applyContentMethod = static::$defApplyContentMethod;

		if (is_string($contentCfg)) {
			return $contentCfg;
		}

		if (isAssoc($contentCfg)) {
			return call_user_func($applyContentMethod, $contentCfg);
			//return static::applyContentCtx($contentCfg);
		}

		if (isOrdinal($contentCfg)) {
			//dx(isOrdinal($contentCfg), isArrayOfArrays($contentCfg));
			if (isArrayOfArrays($contentCfg)) {
				return static::applyContentsCtx(array('contents' => $contentCfg));
			} else {
				return static::applyContentTpl($contentCfg);
			}
		}

		return $contentCfg;
	}

}
