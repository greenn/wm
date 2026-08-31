<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
ob_start();
?>
	<style>
		BODY { background-color: lightgoldenrodyellow }
        BUTTON { font: 12px monospace; margin-left: 6px; }
        BUTTON[raw] { color: darkgreen }
        BUTTON[hide] { color: darkred }
        BUTTON[unhide] { color: orangered }
	</style>

	<script>

        vue_app(function(_log){
            var _obj, _self;
            return {
                data: function(){

                    return {
                        prop: 11,
                        obj: _obj = {
                            prop1: 5,
                            _prop1: function(force){
                                this.prop1 += 1
                                _log('_self.$set', _self.$set);

                                force && _self.$forceUpdate();
                            },
                            _prop2: function(force){
                                this.prop2 = this.prop2 ? ++this.prop2 : 1
                                force && _self.$forceUpdate();
                            },
                        },
                        stack: [],

                        props: {
                            a: 10
                        }
                    }

                },
                methods: {
                    changeProp: function(){
                        this.prop += 1
                    },
                    changeObjProp1: function(){
                        this.obj.prop1 += 1
                    },
                    hideChangeObjProp1: function(){
                        _obj._prop1();
                    },
                    unhideChangeObjProp1: function(){
                        _obj._prop1(true);
                    },

                    changeObjProp2: function(){
                        this.obj.prop2 = this.obj.prop2 ? ++this.obj.prop2 : 1
                    },
                    hideChangeObjProp2: function(){
                        _obj._prop2();
                    },
                    unhideChangeObjProp2: function(){
                        _obj._prop2(true);
                    },
                    changeStack: function(){
                        this.stack[this.stack.length - 1] += 1
                    },
                    pushStack: function(){
                        this.stack.push(1)
                    },


                    addProps: function(){
                        var n = _.size(this.props)
                        this.props['a' + n] = true;
                    },
                },

                watch: {
                    prop: function(value){
                        _log('w:prop', value)
                    },
                    obj: {
                        handler: function(value){
                            _log('w:obj', value)
                        },
                        deep: true,
                        // force eager callback execution
                        //immediate: true
                        //flush: 'post'
                    },

                    stack: {
                        handler: function(value){
                            _log('w:stack', value)
                        },
                        deep: true
                    },
                },
                mounted: function(){
                    _self = this;
                    console.dir(_self.$data)
                }
            }

        }, function(){
            App = _App.mount('#eg');
        })


    </script>

    <section id="eg">
        <div>
            <b>{{ prop }}</b>
            <button raw @click="prop += 1">change prop</button>
            <button @click="changeProp">changeProp</button>
        </div>

        <div>
            <b>{{ obj.prop1 }}</b>
            <button raw @click="obj.prop1 += 1">change obj.prop1</button>
            <button @click="changeObjProp1">changeObjProp1</button>
            <button hide @click="hideChangeObjProp1">hideChangeObjProp1</button>
            <button unhide @click="unhideChangeObjProp1">unhideChangeObjProp1</button>
        </div>
        <div>
            <b>{{ obj.prop2 }}</b>
            <button raw @click="obj.prop2 = obj.prop2 ? ++obj.prop2 : 1">change obj.prop2</button>
            <button @click="changeObjProp2">changeObjProp2</button>
            <button hide @click="hideChangeObjProp2">hideChangeObjProp2</button>
            <button unhide @click="unhideChangeObjProp2">unhideChangeObjProp2</button>
        </div>

        <div>
            <b>{{ stack }}</b>

            <button raw @click="stack.push(1)">push stack</button>
            <button @click="pushStack">pushStack</button>

            <button raw @click="stack[stack.length - 1] += 1">change stack</button>
            <button @click="changeStack">changeStack</button>
        </div>
        <div>
            <div>{{ props }}</div>
            <button @click="addProps">addProps</button>
        </div>

    </section>
<?
$body = ob_get_clean();

print rb_tpl('page', 'page', array(
	'pageTitle' => 'Vue-Env',
	'body' => $body,
	'webkit' => array(
		'vue-env'
	),
));