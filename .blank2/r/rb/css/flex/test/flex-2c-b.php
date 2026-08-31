<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('pcss');

$Self = _rb::self();

$Self::req_css('flex');
_rp::req_css('ui', 'css/ft');


ob_start(); ?>

    <style type="text/css">
        MAIN { padding: 30px; width: 300px; height: 100px; border: 1px dotted royalblue; }
        SECTION { border: 1px dashed greenyellow; }

        [content] { border: 1px solid chocolate }

        [col] {
            background-color: rgba(30, 144, 255, .4);
        }
    </style>


    <main>
        <section fxi="c">
            <div col>
                <input type="checkbox" />
            </div>
            <div col>
                <label class="ft-large">text text</label>
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