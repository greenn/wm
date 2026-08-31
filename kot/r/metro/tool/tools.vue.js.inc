<?
$Self = _kot::self();
$Self::req_vue('clear-rn', array(), 'tool-clear-rn');
//$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'))
?>

_vue('tools', function(_log, _cmd){

    return {
        template: ' ',

        _vue: {
            routes: function(App, SelfCmpt){
                var root = this;
                //_log('pro vide/routes', { root, App, SelfCmpt, RelCmpt: root.getDecl('target-form') })
                return [
                    {
                        name: 'tool-clear-rn',
                        path: '<?=_kot::namedUrl('tool-clear-rn')?>',
                        //path: '<?=_kot::namedUrl('test1', ":id(\\\\d+)")?>',
                        component: root.getDecl('tool-clear-rn'),
                        meta: {
                            pageTitle: 'Удаление новых строк',
                            //keepAlive: true
                        }
                    },

                ];
            },

            provide: [
                { 'linkRel': '<?=_kot::namedUrl('tools')?>' },
            ],
        }
    }
})