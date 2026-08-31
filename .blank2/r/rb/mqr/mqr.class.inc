<?//v1
/*v2 oo
	site_w
	site_w_ns
	site_w_mqr
	_site_w

*/

_rb::reg('mqr', array());

class rb_mqr extends rb {

	static function a_mqr_byCtx($ctx){
		return static::a_mqr(
			_prop($ctx, 'mqr'),
			_prop($ctx, 'mqr-dbg')
		);
	}

	static function a_mqr($mqr = '', $mqrDbg = false){
		$a_mqr = '';
		if ($mqr) {
			$mqrOpts = is_array($mqr) ? $mqr : explode(',', is_string($mqr) ? $mqr : '');
			if ($mqrDbg) {
				$mqrOpts = array_pad($mqrOpts, 3, '');
				//while (count($mqrOpts) < 2) $mqrOpts[] = '';
				$mqrOpts[2] = $mqrDbg;
			}
			//dx($mqrDbg, $mqrOpts);
			$a_mqr = $mqrOpts ? 'mqr="'.join(',', $mqrOpts).'"': 'mqr';
			//$a_mqr = (is_string($mqr) && $mqr) ? "mqr=\"$mqr\"": 'mqr';
		}
		return $a_mqr;

	}
}
