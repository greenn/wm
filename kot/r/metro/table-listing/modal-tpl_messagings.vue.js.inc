<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
//js::wreq('external-click.jq');
?>

_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                //'getRealParent', @provide crud-modal

                { 'linkRel': '<?=_kot::namedUrl('tmsgs')?>' },

                { 'crud-modal': {
                    rName: 'tpl_messagings',
                    methods: [
                        'info',
                        'preview',
                        'aproove',
                        'reject',
                        'copy',
                        'delete',
                    ]

                } },
            ]
        },

        emits: [
            //'onModalOpen', //2)
            //'onDelete',
            //'onCopy',
        ],

        props: ['item'],

        methods: {
            //@crud-modal
                //getButton()
                //onAprooved()
                //toggle()
        },

        watch: {
            //'item.aprooved': @crud-modal
        },

        //mounted() @crud-modal
    }
})