<?#5.1.1-1
//echo 'Технический анализ рекламного трафика'; exit;
//echo 'Предиктивный анализ ставок Яндекс.Директа.'; exit;


include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
//site_router::uc_page('Идёт сбор данных для Яндекс'); //Яндекс сбор данных
//site_router::uc_page('Настройка Яндекс.Директ');

if (0 && 'dd') site_router::uc_apply(true, [
	//'Идёт сбор данных для Яндекс',
	'идёт подлкючение к яндексу',

	[]
]);

site_router::applyHandlerByUri(true, true, true); //web/php/site/v2/router/site.php