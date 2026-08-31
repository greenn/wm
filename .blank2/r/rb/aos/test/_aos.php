<?

include_once $_SERVER['DOCUMENT_ROOT'] . '/site/iq.inc';

need_rp('aos');






if (!1 && 'default') {
	d(_aos('dly:800 dur:100ms'));
	d(_aos('opacity 1s ease 100ms'));
	d(_aos('opacity 500 100'));
	d(_aos('fade-down delay:350 easing:ease-out-cubic'));

	d(_aos('500 100'));
	d(_aos('fade-up linear'));
}

if (!1 && 'wrong order') { //done
	d(_aos('easing:ease-out-cubic fade-down'));
}


if (!1 && 'custom-names') { //не работает (как ожидается) - такой беспредел не планируется
	d(_aos('custom:ease-4  id5:fade-down'));
}

if (!1 && 'id-name') {
	d(_aos('id:ease-4 custom:fade-down'));
}

if (!!1 && 'usage-eg') {
	//d(_aos('fade-down 800 1000'));
	//d(_aos('t:1000', 'name:fade-right', 'd:'.(850 + 150)));
	d(_aos('fade-down', 'ease-out-cubic'));
	//d(_aos('fade-down ease-out-cubic'));
}

