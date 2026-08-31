<?#3.0.1
_addphp('fq/_select');

if (!is_callable('cbn')) {

function cbn($val){
    static $data = array(
        /*
            моментальное - easeOutCirc
            ровное движение - linear
            равномерное появление - easeOutSine
            замедленное появление - easeInQuint
            медленное появление - easeInCirc
            равномерное появление - easeOutSine
            с начальной задержкой - easeInQuart
			со сдвигом - oo shakers
                планое перелевание - easeOutQuart?
        */
        'ease' => '0.25,0.1,0.25,1',
        'linear' => '0.250,0.250,0.750,0.750',
        'easeOutBack' => '0.175,0.885,0.32,1.275',# http://easings.net/ru#easeOutBack
        'easeInOutBack' => '0.68,-0.55,0.265,1.55',# http://easings.net/ru#easeInOutBack
        'easeInBack' => '0.6,-0.28,0.735,0.045',# http://easings.net/ru#easeInBack
        'easeOutCirc' => '0.075,0.82,0.165,1',# http://easings.net/ru#easeOutCirc
        'easeInQuint' => '0.755,0.05,0.855,0.06',# http://easings.net/ru#easeInQuint
        'easeOutCubic' => '0.215,0.61,0.355,1',# http://easings.net/ru#easeOutCubic
        'easeInOutCirc' => '0.785,0.135,0.15,0.86',# http://easings.net/ru#easeInOutCirc
        'easeInOutQuint' => '0.86,0,0.07,1',# http://easings.net/ru#easeInOutQuint
        'easeInExpo' => '0.95,0.05,0.795,0.035',# http://easings.net/ru#easeInExpo
        'easeInCirc' => '0.6,0.04,0.98,0.335',# http://easings.net/ru#easeInCirc
        'easeInOutSine' => '0.445,0.05,0.55,0.95',# http://easings.net/ru#easeInOutSine
        'easeInQuart' => '0.895,0.03,0.685,0.22',# http://easings.net/ru#easeInQuart
        'easeOutQuart' => '0.165,0.84,0.44,1',# http://easings.net/ru#easeOutQuart
        'easeInOutQuad' => '0.455,0.03,0.515,0.955',# http://easings.net/ru#easeInOutQuad
        'easeInOutCubic' => '0.645,0.045,0.355,1',# http://easings.net/ru#easeInOutCubic
        'easeInOutQuart' => '0.77,0,0.175,1',# http://easings.net/ru#easeInOutQuart
        'easeOutQuad' => '0.25,0.46,0.45,0.94',# https://easings.net/ru#easeOutQuad
        'easeOutSine' => '0.39,0.575,0.565,1',# http://easings.net/ru#easeOutSine
        'easeOutQuint' => '0.23,1,0.32,1',# http://easings.net/ru#easeOutQuint
        'easeInCubic' => '0.55,0.055,0.675,0.19',# http://easings.net/ru#easeInCubic

        'inBack' => '0.6,-0.28,0.74,0.05',# chrome

        //shakers
        '-easeOutElastic' => '',# http://easings.net/ru#easeOutElastic
        '-easeInOutElastic' => '',# http://easings.net/ru#easeInOutElastic

        //https://matthewlein.com/ceaser/
        'c-sin-1f' => '0.000,1.650,1.000,-0.600',
        'q-opc-1' => '0.000,1.650,0.450,0.940',

	    //cubic-bezier(.42,0,.47,1.16)
        'easy-in-out-q' => '0.42,0,0.47,1.16',//https://cubic-bezier.com/#.42,0,.47,1.16
        'line' => '0,0,1,1',//https://cubic-bezier.com/#0,0,1,1
        'ease-line' => '.87,.2,.71,.87',//https://cubic-bezier.com/#.87,.2,.71,.87
        'ease-line-back' => '.58,.18,.28,.86', //https://cubic-bezier.com/#.87,.2,.71,.87
        'ease-in-out' => '.58,.18,.28,.86', //с-зависанием https://cubic-bezier.com/#.47,1.11,.69,.23
        'ease-in-sine' => '.39,.07,.56,1', //с плавным отстованием https://cubic-bezier.com/#.39,.07,.56,1

		'yflip-1' => '0.39, 0.34, 0.16, 1.13', //вращение объекта по горизонтале [ug pcss('animation', "1000ms ".cbn('yflip-1')." infinite yflip")]

		//chrome
		'emphasized' => array('linear(0 0%, 0 1.8%, 0.01 3.6%, 0.03 6.35%, 0.07 9.1%, 0.13 11.4%, 0.19 13.4%, 0.27 15%, 0.34 16.1%, 0.54 18.35%, 0.66 20.6%, 0.72 22.4%, 0.77 24.6%, 0.81 27.3%, 0.85 30.4%, 0.88 35.1%, 0.92 40.6%, 0.94 47.2%, 0.96 55%, 0.98 64%, 0.99 74.4%, 1 86.4%, 1 100%)'),
		'elastic' => array('linear(0 0%, 0.22 2.1%, 0.86 6.5%, 1.11 8.6%, 1.3 10.7%, 1.35 11.8%, 1.37 12.9%, 1.37 13.7%, 1.36 14.5%, 1.32 16.2%, 1.03 21.8%, 0.94 24%, 0.89 25.9%, 0.88 26.85%, 0.87 27.8%, 0.87 29.25%, 0.88 30.7%, 0.91 32.4%, 0.98 36.4%, 1.01 38.3%, 1.04 40.5%, 1.05 42.7%, 1.05 44.1%, 1.04 45.7%, 1 53.3%, 0.99 55.4%, 0.98 57.5%, 0.99 60.7%, 1 68.1%, 1.01 72.2%, 1 86.7%, 1 100%)'),


    );


    //sugar-possibility, choose by index
	$args = func_get_args();
	$val = csArg($args);

	/*$args = func_get_args();
	$argsN = count($args);
    if ($argsN > 1) {
    	$selecterIndex = $argsN - 1;
	    $select = $args[$selecterIndex];
    	if (is_numeric($select) && ($select !== $selecterIndex) && isset($args[$select])) {
		    $val = $args[$select];
	    }
    }*/


    if (isset($data[$val])) {
	    $val = $data[$val];
    }

	if (is_array($val)) return $val[0];

    return "cubic-bezier($val)";
}

/*

http://easings.net/ru

 */
 }