<?

return array(
	//'redirect' => '/company',

	'title' => array(
		'page' => 'Контакты',
		'menu' => 'Контакты',
		'content' => 'Контактная информация',
	),
	'link' => array(
		//'uri' => false
	),
	'footer-menu' => array(
		'pic' => 'icon/contact/1/bird-contact.png',
		//'h' => 65,
		//'pic' => 'icon/graniplace/logo-header.w_03.png',
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
			'content-tpl' => array('banner', 'banner', array(
				'pic' => 'banner/2/diz_38.png'
			))
		),
		array(
			'content-title' => '',
			'content-tpl' => array('contact', 'info')
		)
	),

);