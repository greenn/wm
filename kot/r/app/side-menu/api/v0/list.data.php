<?#2.0
//note: закрыто от внешнего вызова (т.к. расширение php)

_needphp('parser/strTabMenuParser.class');

$data = <<<text
Каталог \ name=catalog expanded=true
	Памятники \ name=catalog-tombs link=tombs
Site \ name=site expanded=true
	Страницы \ name=site-pages
	Лого \ name=logo
	Верхнее меню \ name=site-menu
	О компании \ name=company-titul
SEO \ name=seo
	robots.txt \ name=robots-txt
Admin \ name=admin
	blank \ name=admin-blank
	menu \ name=admin-menu
	r \ name=admin-r link=r
		kmod \ name=admin-r-kmod link=kmod
Tools
	guzzler \ name=guzzler
Sandbox
	blank \ name=blank
	body bg \ name=body-bg

Metro \ link=metro
	Таргеты \ name=trg-par link=notify
		Рассылки \ id=4 name=msgs link=bulk-messagings
		Шаблоны рассылок \ name=tmsgs link=bulk-messaging-templates
		Шаблоны таргетов \ name=trg link=targeting-templates
	Тест \ name=test-par link=tests
		Тест 1 \ name=test1 link=test-1
		Тест 2 \ name=test2 link=test-2
		Тест 3 \ name=test3 link=test-3
		v2-target \ name=v2trg link=test-4
text;


//Kint::$maxLevels = 20;
//dx(strTabMenuParser::parse($data));

return strTabMenuParser::parse($data);
