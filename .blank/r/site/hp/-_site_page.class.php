<?
class _site_page {
	//показ страницы по page-id
	static function pid($pid){
		//oo .b/page.class.php
		static $pidMap = array(
			//'landing' => array('landing', 'landing') //def auto logic eg
			'404' => array('error', '404')
		);
		$rSet = prop($pidMap, $pid);
		if (!$rSet) { //case: auto-set
			$rSet = array($pid, $pid, array());
		}
		list($rName, $tplName) = $rSet;
		$tplCtx = prop($rSet, 2, array());

		$content = site_tpl($rName, $tplName, $tplCtx);

		return site_page::html('page', 'page', array(
			'content' => $content
		));
	}



	//сгенерить контент страницы
	static function content($content){
		return site_page::tpl('html', array(
			'body' => site_page::tpl('page', array(
				'content' => $content
			))
		));
	}

	//составить страницу с базовыми проектными css и js
	static function html($rName, $tplName, $tplCtx = array()){
		$body = site_tpl($rName, $tplName, $tplCtx); //сгенерить HTML страницы

		return site_page::tpl('html', array(
			'body' => $body
		));
	}

}
