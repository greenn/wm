<?#2.17.1
# [oo] web/test/web/php/addphp.php


/*
	принимать конструкции, внешних зависимостей
		еg: '@site/php/site.php',
*/
function needphp(/* $phpName1, ..., $phpNameN */){

	if (func_num_args() > 0) {
		$fileNames = func_get_args();
		foreach ($fileNames as $fileName) {
			//print $fileName.'<br />';
			addphp($fileName);
		}
	}

}

/* id 4r

	вариант вызова версии для php-вызова
		_needphp('wr:2');
			парсит и грузит
				web/php/wr/2
*/

/* id 3

    если нет в папке php
        то смотрите в стеке php/s
        копирует его в php
            и потом только инклюдит

        будет видно сразу только те файлы, что используются в данном проекте

*/

/*
add
	user versions
		n
names
	phpneed

id
	namedId
		as $thisAllias = array();
	с возможностью подргрузкой по аллиасом
		нужно ли*
*/

