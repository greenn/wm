<?#7.2.0
_needphp(
	'x',
	'g',
	'set'
);
/*
	[ff] cache template im memory [rz to not include each time]
*/
/*
	получает строковый-результат
		из файла по переданному пути (аргумент 1)
		предварительно создав переменные из контекста (аргумент 2)
		выполнив замену конструкий (аргумент 3)

	x('__useTemplate')
	x('__templateResult')
	x('__templatePath')
	x('__templateCtx')
*/

//d('~');

x('__templatePath', array());
x('__templateCtx', array());
//x('__templateResult', array());
//x('__useTemplate', array());

//[rbY useCleanTemplate]
function useTemplate(/*__templatePath, __templateCtx, $templateSubstitutions, $substituteWithRegex*/){
	//[x()] чтобы не вносить своих переменных в инклюд
        //[ad - хотя как вариант иметь на свой темплейт или данные ссылку,
        //  тогда можно сделать опять же через x(), но выьрать более подходящее названия] [y/dn]
		//      [v] локальные переменные = полезные особенности / полный контекст [__templateCtx]; ссылка на себя [__templatePath] )
		//          [re] доступ к этому есть уже через x() - x('__templateCtx');
		//              [aga] с которым есть проблема, когда ты хочешь обратиться к этом x() а он уже перезаписы внутрннем вызовом useTemplate
		/*  sol
			x('__templatePath', array());
			x('__templateCtx', array());
			x('__templateResult', array());
				и делать array_push() и array_pop();
		*/

	if (func_num_args() > 0) {
		x_push('__templatePath', func_get_arg(0));

		if (is_file(x_end('__templatePath'))) {

			if (func_num_args() > 1) {
                x_push('__templateCtx', func_get_arg(1));
				if (is_array(x_end('__templateCtx'))) {
					extract(x_end('__templateCtx'));
				}
			}

			//if (x('fk-dbg'))
			//dx(x_end('__templatePath'), x_end('__templateCtx'));
			gIncr('preventHeaders');
			//d(g('preventHeaders'), x('__templatePath'));
			x('__useTemplate', true); //x_push('__useTemplate', true) и для проверка использовать x_end('__useTemplate')
			ob_start();
			include (x_end('__templatePath'));
			$templateResult = ob_get_clean();
			//dx('useTemplate/included', g('preventHeaders'));
			x('__useTemplate', false); //x_pop('__useTemplate)
			gDecr('preventHeaders');
			//d(g('preventHeaders'), func_get_arg(0));


            if (func_num_args() >= 3) {
                $templateSubstitutions = func_get_arg(2);
                if (is_array($templateSubstitutions)) {
                    $substituteWithRegex = func_num_args() == 4 ? func_get_arg(3) : false;
                    if (!$substituteWithRegex) {

                        $templateResult = strtr($templateResult, $templateSubstitutions);

                    } else { //используем замену с помощью регулярных варажений
                        //[eg web/test/php/useTemplate/regex.php]

                        $set = set(); $set->setData($substituteWithRegex); //set(false, $substituteWithRegex)
                        $search = array_keys($templateSubstitutions);
                        $replace = array_values($templateSubstitutions);

                        if (!$set->off) { //off - отмена какой либо трансформации данных (оборачивания значений в regex)
                            //[el] возможно добавления своих модификаторов и т.д

                            if ($set->b) { //замена только слов / использование метки "Граница слова": \b
                                foreach ($search as $index => $value) {
                                    $search[$index] = "\b$value\b";
                                }
                            }

                            //трансформация данных в regex-выражения
                            foreach ($search as $index => $value) {
                                $search[$index] = "~$value~";
                            }
                        }

                        $templateResult = preg_replace($search, $replace, $templateResult);


                    }

                }
            }

            x('__templateResult', $templateResult);
		}

	}

    $templateResult = x('__templateResult'); //чтобы в начале не объявлять или использовать isset($templateResult)

	x_pop('__templatePath');
	x_pop('__templateCtx');
    x('__templateResult', null);

	//dx('useTemplate/end', g('preventHeaders'));
	return $templateResult;
}


function useTemplate_8($templatePath, $templateCtx = array(), $templateSubstitutions = false, $substituteWithRegex = false){
	$templateResult = '';

	if (is_file($templatePath)) {

		if (is_array($templateCtx)) {
			extract($templateCtx);
		}

		//L7
		x_push('__templatePath', $templatePath);
		x_push('__templateCtx', $templateCtx);


		gIncr('preventHeaders');
		x('__useTemplate', true);
		ob_start();
		include $templatePath;
		$templateResult = ob_get_clean();
		x('__useTemplate', false);
		gDecr('preventHeaders');

		//L7
		x_pop('__templatePath');
		x_pop('__templateCtx');

		if (is_array($templateSubstitutions)) {

			if ($substituteWithRegex) { //используем замену с помощью регулярных варажений
				//[eg web/test/php/useTemplate/regex.php]

				$set = set(); $set->setData($substituteWithRegex); //set(false, $substituteWithRegex)
				$search = array_keys($templateSubstitutions);
				$replace = array_values($templateSubstitutions);

				if (!$set->off) { //off - отмена какой либо трансформации данных (оборачивания значений в regex)
					//[el] возможно добавления своих модификаторов и т.д

					if ($set->b) { //замена только слов / использование метки "Граница слова": \b
						foreach ($search as $index => $value) {
							$search[$index] = "\b$value\b";
						}
					}

					//трансформация данных в regex-выражения
					foreach ($search as $index => $value) {
						$search[$index] = "~$value~";
					}
				}

				$templateResult = preg_replace($search, $replace, $templateResult);


			} else {

				$templateResult = strtr($templateResult, $templateSubstitutions);

			}

		}
	}

	return $templateResult;
}