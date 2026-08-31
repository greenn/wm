<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){


    return {
        props: ['title', 'open', 'toggler', 'icon'],

        _vue: {
            multiInstances: true,
            provide: [
                //{ 'ui-lay': {} }
            ],
        },

        data(){
            return {}
        },

        methods: {

            toggle: function(){
                var reverseValue = !this.closed;
                this.closed = reverseValue;
            },

<?/*
они будут автоматически вызываться при соответствующих этапах анимации внутри transition.
    beforeEnter: Вызывается перед началом анимации входа.
    enter: Вызывается во время анимации входа.
    afterEnter: Вызывается после завершения анимации входа.
    beforeLeave: Вызывается перед началом анимации исхода.
    leave: Вызывается во время анимации исхода.
    afterLeave: Вызывается после завершения анимации исхода.
*/?>
            beforeEnter(el) {
                _log('beforeEnter', { el, arguments })
            },
            enter(el, done) {
                _log('enter', { el, done, arguments })
            },
            afterEnter(el) {
                _log('afterEnter', { el, arguments })
            },
            enterCancelled(el) {
                _log('enterCancelled', { el, arguments })
            },
            beforeLeave(el) {
                _log('beforeLeave', { el, arguments })
            },
            leave(el, done) {
                _log('leave', { el, arguments })
            },
            afterLeave(el) {
                _log('afterLeave', { el, arguments })
            },
            leaveCancelled(el) {
                _log('leaveCancelled', { el, arguments })
            },
        },

        mounted(){
            //this._log('mounted')
        },
    }
})