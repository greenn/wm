<?
$vueName = basename(__FILE__, '.vue.js.inc');
$Self = _kot::self();

?>
_vue('<?=$vueName?>', function(_log, _cmd){


    return {
        //inheritAttrs: false,

        //emits: ['click'],
        props: ['title', 'open', 'toggler', 'icon'],

        _vue: {
            multiInstances: true,
            provide: [
                //'regField', 'regButton',
                //'link', 'linkBack',
                //'applyRealParentMethod', 'getRealParent',
            ],
        },

        data(){
            //_log('data');
            return {
                //title: this.$attrs.title || '- <?=$vueName?>/title -'
                //title: this.$props.title || '- <?=$vueName?>/title -',
                closed: !this.$props.open,
                hover: false
            }
        },

        methods: {

            toggle: function(){
                var reverseValue = !this.closed;
                this.closed = reverseValue;
            },

<?/*


Да, если вы определите методы beforeEnter, enter, afterEnter, beforeLeave, leave и afterLeave в вашем компоненте, они будут автоматически вызываться при соответствующих этапах анимации внутри transition. Вам не нужно явно вызывать их.

Например, если у вас есть метод beforeEnter, он будет вызываться перед началом анимации входа элемента, определенного в transition. То же самое касается остальных методов:

beforeEnter: Вызывается перед началом анимации входа.
enter: Вызывается во время анимации входа.
afterEnter: Вызывается после завершения анимации входа.
beforeLeave: Вызывается перед началом анимации исхода.
leave: Вызывается во время анимации исхода.
afterLeave: Вызывается после завершения анимации исхода.


*/?>
            beforeEnter(el) {
                _log('beforeEnter')
                el.style.height = 0;
                el.style.overflow = "hidden";
            },

            enter(el, done) {
                _log('enter')
                const increaseHeight = function() {
                    if (el.clientHeight < el.scrollHeight) {
                        const height = `${parseInt(el.style.height) + 5}px`;
                        el.style.height = height;
                    } else {
                        clearInterval(this.enterInterval);
                        done();
                    }
                };
                this.enterInterval = setInterval(increaseHeight, 10);
            },
            afterEnter(el) {
                _log('afterEnter')
            },
            enterCancelled(el) {
                _log('enterCancelled')
                clearInterval(this.enterInterval);
            },
            beforeLeave(el) {
                _log('beforeLeave')
            },
            leave(el, done) {
                _log('leave')
                const decreaseHeight = function() {
                    if (el.clientHeight > 0) {
                        const height = `${parseInt(el.style.height) - 5}px`;
                        el.style.height = height;
                    } else {
                        clearInterval(this.leaveInterval);
                        done();
                    }
                };
                this.leaveInterval = setInterval(decreaseHeight, 10);
            },
            afterLeave(el) {
                _log('afterLeave')
            },
            leaveCancelled(el) {
                _log('leaveCancelled')
                clearInterval(this.leaveInterval);
            },
        },

        mounted(){
            //this._log('mounted')
        },
    }
})