<?
/*
	https://coolors.co/fafafa
	https://yandex.ru/yandsearch?text=цвет яндекса&lr=2
	https://colorscheme.ru/color-names.html
	https://coolors.co/5A616F-606674
*/

<<<css
{
	
	
	color: #675025; /* tc1 */
	color: #504126; /* dark brown */
	color: #86785D; /* light brown */
	color: #B4A282; /* light brown 2 */
	color: #DACBAF; /* light brown 3 */
	
}
css;

$cssColorNames = array(
		'white' => '#FFFFFF',
		'black' => '#000000',
		'dark-blue' => '#1C274C',
		'grey' => '#B8B8B8',

		'red' => '#fc0b3e',
		'fire-red' => '#d62829',

	'tc1' => '#675025',
	'dark brown' => '#504126',
	'light brown' => '#86785D',
	'light brown 2' => '#B4A282',
	'light brown 3' => '#DACBAF',

);


//step: добавляем проименованные название
$cssColors = array(
	'bg-main' => '#F1E6D2',

	'bg-login' => _css('bg-results-pane'),
	'bg-button' => _css('bg-button'),
);

return $cssColorNames + $cssColors;