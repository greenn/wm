<?

_needphp('parser/strTabMenuParser.class');


$data = <<<text
Информирование \ link=pci
	Пассажиры \ link=passenger
		Рассылки \ name=trg-par link=notify
			Рассылки \ id=4 name=msgs link=bulk-messagings
			Шаблоны рассылок \ name=tmsgs link=bulk-messaging-templates
			Шаблоны таргетов \ name=trg link=targeting-templates
		История отправки \ link=/history fake=passenger-history
		События информирования \ link=event-types fake=passenger-event-types
		Типы оповещений \ link=notification-types fake=passenger-notification-types
		Типы каналов \ link=channel-types fake=passenger-channel-types		
	Внешние контрагенты \ link=contractor
		Рассылки 
			Рассылки \ link=bulk-messagings fake=contractor-bulk-messagings
			Шаблоны рассылок \ 
		История отправки \ 
		События информирования \ 
		Типы оповещений \ 
		Типы каналов \ 
	Корпоративные клиенты
		Рассылки
			Рассылки \ 
			Шаблоны рассылок \ 
		История отправки \ 
		События информирования \ 
		Типы оповещений \ 
	Внутренние контрагенты
		История отправки \ 
		События информирования \ 
		Типы оповещений \ 
		Типы каналов \ 
	Отчёты
		Статистика отправленных SMS \ 
text;

$testData = <<<text
Тест \ name=test-par link=tests
	Тест 1 \ name=test1 link=test-1
	Тест 2 \ name=test2 link=test-2
	Тест 3 \ name=test3 link=test-3
	v2-target \ name=v2trg link=test-4
text;

if (isMe) $data = join(newline, array($testData, $data));

//Kint::$maxLevels = 20;

return strTabMenuParser::parse($data);
