<?

return array(
	//'redirect' => '/company',

	'title' => array(
		'page' => 'Виды похоронных услуг',
		'menu' => 'Услуги',
		'content' => 'Все для проведения похорон',
	),

	'page-ctx' => array(
		'content-pb' => false,
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
			'content-tpl' => array('posts', 'services', array(
				'use-links' => true
			)),
			'content-w' => false,
		),

		array(
			'content-title' => '',
			//'content-tpl' => array('posts', 'data/content/rituals-1'),
			'content-tpl' => array('posts', 'data/content/rituals'),
		)
	),


);