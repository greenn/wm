<?//libConnector #3.0.2

/*

	_lib('simple_html_dom')

	man
		https://simplehtmldom.sourceforge.io/
		https://simplehtmldom.sourceforge.io/manual.htm
		https://simplehtmldom.sourceforge.io/manual_api.htm

		https://sourceforge.net/p/simplehtmldom/feature-requests/

		selectors
			http://17.web/
				web/lib/simple_html_dom/simplehtmldom_1_9_1/manual/docs/api/api.md


	qa
		https://stackoverflow.com/questions/4791629/how-do-i-find-the-last-div-class-in-an-html-file-with-php-simple-html-dom-pars

		https://stackoverflow.com/questions/4812691/preserve-line-breaks-simple-html-dom-parser
			file_get_html($url, $use_include_path = false, $context=null, $offset = -1, $maxLen=-1, $lowercase = true, $forceTagsClosed=true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN=true, $defaultBRText=DEFAULT_BR_TEXT)
	ug
		C:\S17\OpenServer\domains b\import.dk\site\rp\import\php\data_crawler.class.php
		C:\S17\OpenServer\domains b\import.dk\site\rp\crawler\crawled_url.class.php
	eg
		$dom = file_get_html($this->url);
		$res = $dom->find($sr, $prm);


*/

$libConnector = dirname(__FILE__).'/simplehtmldom_1_9_1/simple_html_dom.php';
//$libConnector = dirname(__FILE__).'/simplehtmldom_1_9_1/simple_html_dom.my.php';

require_once $libConnector;


function file_get_sr(){}
function url_get_html(){}