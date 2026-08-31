<?#0.5.1032
$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
	'req' => false,
	'wjs' => false,
));

$list = $_ctx['req'];
$wjs = $_ctx['wjs'];
//dx($list, $wjs);

$useMin = defined('productionMod') && constant('productionMod');

if ($list) foreach ($list as $req) {
	$ctx = array();
	if (is_array($req)) {
		$ctx = (array) $req[1];
		$req = $req[0];
	}
	switch ($req) {
		case 'lodash':  {
			js::req(-25, false, '/js/lodash/4.17.21/lodash.min.js');
		} break;
		case 'jquery':  {
			js::req(-24, false, '/js/jquery/1.12.4/jquery.min.js');
		} break;
		case 'knockout':  {
			$suffix = $useMin ? '' : '.debug';
			js::req(-23, false, "/js/knockout/3.5.1/knockout-latest{$suffix}.js");
		} break;

		case 'axios':  {
			js::req(-20, false, '/js/axios/0.24.0/axios.js');
		} break;
		case 'qs':  {
			//js::req(-20, false, '/js/qs/6.10.3/qs.min.js');
			js::req(-20, false, '/js/qs/6.10.3/qs.js');
			//js::req(-20, false, '/js/qs/6.5.1/qs.min.js');
		} break;

		case 'emittery':  {
			js::req(-19, false, '/js/emittery/0.6.0/index.standalone.js');
			js::req(-19, false, false, 'var emittery = new Emittery();');
		} break;


		case 'w-storage': {
			//-9
			js::req(-18, false, '/js/w-storage/5.0.0/storage.js');
			source::req_name('knockout');
			//$Self::call('webkit/main', array('req' => 'knockout'));
		} break;

		case 'w-evoke': {
			js::req(-20, false, '/js/w-evoke/evokeManager.js');
		} break;

		case 'pending_fn': {
			js::req(-20, false, '/js/w-pending_fn/pending_fn.js');
		} break;

		case 'vue':  {
			js::req(-15, false, '/js/vue/3.2.20/vue.global.js');
		} break;
		case 'vue-init':  {
			$appName = prop($ctx, 0, 'App');
			js::req(-2, false, array('vue', 'vue-init', $ctx + array('app' => $appName)));
		} break;
		case 'vue-router':  {
			js::req(-10, false, '/js/vue-router/4.0.12/vue-router.global.js');
		} break;
		case 'vue-storage':  {
			js::req(-10, false, '/js/vue-storage/3.1.0/vuejs-storage.umd.min.js');
		} break;
		case 'vuex':  {
			js::req(-1, false, '/js/vuex/4.0.2/vuex.global.js');
		} break;

		case 'vue-env':  {
			_rb::req_js(-5, 'vue', 'env'); //rb/vue/env.js.php:73
			/*
			    'vue',
				'jquery',
				'lodash',
				'w-storage',
			    'axios',
			    'emittery'
			 */
		} break;
		case 'vue-env-2': {
			_rb::req_js(-5, 'vue', 'env?v3');
			$Self::webkit('moment');
			$Self::webkit('jquery');
			$Self::webkit('lodash');
		} break;

		case 'vuetify':  {
			//css::req(-2, false, '/js/vuetify/3.3.14/vuetify.min.css');
			//css::req(-2, false, '/js/vuetify/3.3.14/vuetify.min.css');
			css::req(-2, false, '/js/vuetify/3.3.14/vuetify.re.css');
			js::req(-2, false, '/js/vuetify/3.3.14/vuetify.min.js');
		} break;

		case 'vue-material':  {//542
			//css::req(-2, false, '/js/vue-material/1.0.0/vue-material.min.css');
			//js::req(-2, false, '/js/vue-material/1.0.0/vue-material.min.js');

			//js::req(-2, false, '/js/vue-material-components/0.3.4/vue-material-components.js');
			//css::req(-2, false, '/js/vue-material-components/0.3.4/vue-material-components.min.css');
		} break;



		case 'jq-datepicker':  {
			css::req(-5, false, '/js/jquery-datepicker/1.12.1/jquery-ui.css');
			js::req(-5, false, '/js/jquery-datepicker/1.12.1/jquery-ui.js');
			js::req(-5, false, false, <<<js
/* Локализация datepicker */
$.datepicker.regional['ru'] = {
    closeText: 'Закрыть',
    prevText: 'Предыдущий',
    nextText: 'Следующий',
    currentText: 'Сегодня',
    monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
    monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
    dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
    dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
    dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
    weekHeader: 'Не',
    dateFormat: 'dd.mm.yy',
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: ''
};
$.datepicker.setDefaults($.datepicker.regional['ru']);
js
			);
		} break;

		case 'imask':  {
			js::req(-5, false, '/js/imask/6.2.2/imask.min.js');
		} break;


		case 'moment':  {
			js::req(-1, false, '/js/moment.js/2.29.1/moment.min.js');
		} break;
		case 'moment-full':  {
			js::req(-1, false, '/js/moment.js/2.29.1/moment-with-locales.min.js');
		} break;

		case 'reset-css': { //012
			rb('page', 'req_css', 'css/reset'); break;
		} break;

		case 'base-css': { //012
			rb('page', 'req_css', 'css/base'); break;
		} break;

		case 'animate-css': { //012
			css::req(false, '/css/animate/411/animate.css');
			//static::req_css(array('/css/animate/411/animate.css'));
		} break;

		case 'fas': { //012
			//https://cdnjs.com/libraries/font-awesome
			css::req(false, 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
			js::req(false, 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js');

		} break;
	}
}

//id
//надо выводить скрипт из под web, который вне хостинга
if ($wjs) {
	///wjs::req('llog');
	_needphp('needjs/wjs');
	dx($wjs);
	foreach ($wjs as $req) {
		wjs::req($req);
	}
}