<?
_blankRm::reg('demo', array('nc' => array('base' => 'blank-rm-demo')));

class blankRm_demo extends blankRm {
    function registerSources(){
        // Explicit extensions; UV is a separate site/project contract.
        static::req_css(-10, 'demo', 'css', false);
        static::req_js(10, 'demo', 'js', false);
    }
}
