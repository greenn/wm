<?
_blankRm::reg('demo', array(
    'nc' => array(
        'base' => 'blank-rm-demo',
    ),
));

class blankRm_demo extends blankRm {
    function registerSources(){
        static::req_css(-20, 'demo', true, false);
        static::req_js(20, 'demo', true, false);
    }
}
