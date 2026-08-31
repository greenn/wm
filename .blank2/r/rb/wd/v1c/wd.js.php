<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Self = _rb::self();
$vn = $Self::relDir();
$n = $Self::nc($vn);

headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(
		$n
	),
	__FILE__
), SITE_CACHE);
?>
WD_<?=$vn?> = function(ctx){
    WD.add_cmd(_.defaults(ctx, {
        ncPos: '-cb', //-lb
        cmd: [ //get_cmd(name, ctx, self)
            'o',
            //'hoverable',sou
            ['hoverable', { name: 'h1' }, { nc: 'hover1' }],
            ['hoverable', { name: 'h2' }, { nc: 'hover2' }],
            ['op', false, { ncView: '.<?=$n?>-view' } ],
            ['off', { name: 'view' }, { ncView: '.<?=$n?>-view' } ],
            ['off', { name: 'embody' }, { ncView: '.<?=$n?>-embody' } ],

        ],
    }))
}