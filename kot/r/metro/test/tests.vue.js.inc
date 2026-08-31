<?
$Self = _kot::self();
$Self::req_vue('test-1');
$Self::req_vue('test-2');
$Self::req_vue('test-3');
$Self::req_vue('test-4');
?>

_vue('tests', function(_log, _cmd){

    return {
        template: ' ',

        _vue: {
            routes: function(App, SelfCmpt){
                var root = this;
                //_log('pro vide/routes', { root, App, SelfCmpt, RelCmpt: root.getDecl('target-form') })
                return [
                    {
                        name: 'test1',
                        path: '<?=_kot::namedUrl('test1')?>',
                        //path: '<?=_kot::namedUrl('test1', ":id(\\\\d+)")?>',
                        component: root.getDecl('test-1'),
                        meta: {
                            pageTitle: 'тест 1',
                            //keepAlive: true
                        }
                    },
                    {
                        name: 'test2',
                        path: '<?=_kot::namedUrl('test2')?>',
                        component: root.getDecl('test-2'),
                        meta: {
                            pageTitle: 'тест 2',
                            //keepAlive: true
                        }
                    },
                    {
                        name: 'test3',
                        path: '<?=_kot::namedUrl('test3')?>',
                        component: root.getDecl('test-3'),
                        meta: {
                            pageTitle: 'тест 3',
                            //keepAlive: true
                        }
                    },
                    {
                        name: 'v2trg', //ak test4
                        path: '<?=_kot::namedUrl('test4')?>',
                        component: root.getDecl('test-4'),
                        meta: {
                            pageTitle: 'v2-target',
                            //keepAlive: true
                        }
                    }
                ];
            },

            provide: [
                { 'linkRel': '<?=_kot::namedUrl('test-par')?>' },
            ],
        }
    }
})