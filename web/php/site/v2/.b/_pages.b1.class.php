<?
class _pages {


	static $curPage;
	static function curPageSet($Page = true){
		if ($Page === true || is_string($Page)) {
			//case до установки curPid получаем данные текущей страницы
			$Uri = site_router::page_uri($Page, pro_opt_env('pages'));
			$Page = $Uri->Page;
		}
		static::$curPage = $Page;
	}
	static function curPid(){
		return static::$curPage ? static::$curPage->pid : null;
	}

	//cur('pages', 'curPage', 'title')
	//cur('pages', 'curPage', 'data', 'title')
	static function curPage(){
		//is prop - show prop
		//is method - call method
		//else show data slice
	}
}