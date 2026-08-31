<?
//note: закрыто от внешнего вызова (т.к. расширение php)

_needphp('parser/strTabMenuParser.class');

$data = <<<text
Site \ link=site name=site expanded=true
	Верхнее меню \ name=site-menu link=site-menu
	О компании \ name=company-titul link=company-titul
SEO \ link=seo name=seo
	robots.txt \ name=robots-txt link=robots-txt
Admin \ link=seo name=seo
	blank \ name=admin-blank link=admin-menu
	menu \ name=admin-menu link=admin-menu
Tools
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

$data = <<<text
Site \ link name=site expanded=true
	Верхнее меню \ name=site-menu	
text;

//Kint::$maxLevels = 20;

return strTabMenuParser::parse($data);
