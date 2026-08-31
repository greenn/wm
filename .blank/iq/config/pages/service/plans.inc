<?

return array(
	//'redirect' => '/company',

	'title' => array(
		'page' => 'Виды похоронных услуг',
		'menu' => 'Стоимость',
		'content' => 'Профессиональная организация похорон',
	),



	'contents' => array(
		array(
			'description' => <<<text
Мы предлагаем полный спектр услуг для проведения похорон и профессионально организуем церемонию прощания, учитывая все пожелания.
<br /> 
Наша поддержка доступна <b fw600>круглосуточно</b>. 
<br />Свяжитесь с нами по телефону или электронной почте, чтобы обсудить все детали. 
<br />
<p fsi>Мы здесь, чтобы помочь вам в эти сложные моменты.</p>
text
		),
		array(
			'content-title' => '',
			'content-tpl' => array('posts', 'tariffs'),
			'content-w' => false,
		),

		array(
			'content-title' => '',
			'content-tpl' => array('posts', 'data/content/plans'),
		)

	),

);