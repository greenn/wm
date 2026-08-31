<?
    $Self = _kot::self()
?>
_vue('http-403', function(_log, _cmd){

    return {
        _vue: {
            provide: [
                'link'
            ],
        },

        ///emits: ['toggleClick'],

        data(){
            //_log('data');

            var links = [];
            links.push({ text: 'Шаблоны таргетов', link: '<?=_kot::namedUrl('trg')?>' })
            links.push({ text: 'Создать шаблон таргетов', link: '<?=_kot::namedUrl('trg', 'add')?>' })
            return {
                links: links
            }
        },

        methods: {},

        mounted(){
            //_log('mounted')
        },
    }
})