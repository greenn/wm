<?

_rb::reg('robots-txt', array(
	'className' => 'rb_robotstxt',
	'nc' => array(
		'base' => 'Rbtx'
	),
));


class rb_robotstxt extends rb {
	static function domainUrl($closingSlash = true, $showProtocol = true) {
		$url = $showProtocol ? hostProtocol : '';
		$url .= site('hostName');
		if ($closingSlash) $url .= '/';
		return $url;
	}
}
