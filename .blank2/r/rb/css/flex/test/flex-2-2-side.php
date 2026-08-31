<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('pcss');

$Self = _rb::self();

_rb::req_css('lay', 'flex'); //$Self::req_css('flex');
_rp::req_css('ui', 'css/ft');


ob_start(); ?>

    <style type="text/css">
        MAIN { padding: 30px; width: 500px; height: 100px; border: 1px dotted royalblue; }
        SECTION { border: 1px dashed greenyellow; }

        [content] { border: 1px solid chocolate }

        [col] {
            background-color: rgba(30, 144, 255, .4);
            min-width: 50px;
        }
    </style>


    <main>
        <section fxr="sb">
            <div wrapper fxr>
                <div col style="height: 50px">1</div>
                <div col>2</div>
            </div>
            <div wrapper fxr>
                <div col>3</div>
                <div col>4</div>
            </div>
        </section>
    </main>

<? $_body = ob_get_clean();

print rb_tpl('page', 'page', array(
	'body' => $_body,
	'webkit' => array(
		'base-css',
		'jquery',
		'lodash',
	)
));