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
                        obj: { a: 10 }
                    }
                },
                methods: {
                    clearObj: function(data){
                        this.obj = {};
                    },

                    nullObj: function(data){
                        this.obj = null;
                    },

                    changeObj: function(obj){
                        this.obj = obj || { z: 1, y: 2}
                    },

                    addProps: function(){
                        var n = _.size(this.obj);
                        this.obj['a' + n] = true;
                    },

                    forceUpdate: function(){
                        this.$forceUpdate();
                    },

                    test1: function(){
                        this.obj = this.obj; //нет эффекта
                    },
                    test2: function(){
                        this.obj = this.obj2; //нет эффекта
                    },
                    test3: function(){
                        // https://stackoverflow.com/questions/122102/what-is-the-most-efficient-way-to-deep-clone-an-object-in-javascript
                        //this.obj = Object.assign({}, this.obj);
                        //this.obj = JSON.parse(JSON.stringify(this.obj));
                        this.obj = { ...this.obj };
                    },
                },

                computed: {
                    obj2: function(){
                        return this.obj;
                    }
                },

                watch: {
                    _obj2: function(value){
                        _log('w:obj2', value)
                    },
                    obj2: {
                        handler: function(value){
                            _log('w:obj2', value)
                        },
                        deep: true
                    },
                    obj: {
                        handler: function(value){
                            _log('w:obj', value)
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
            <button @click="forceUpdate">forceUpdate()</button>
            <button @click="nullObj">null</button>
            <button @click="clearObj">{}</button>
            <button @click="changeObj()">{ z: 1, y: 2 }</button>
            <button @click="addProps">addProps()</button>
            <button @click="test1">test1()</button>
            <button @click="test2">test2()</button>
            <button @click="test3">test3()</button>
        </div>

        <div>
            <div>obj: </div>
            <b ffm>{{ obj }}</b>
        </div>
        <div>
            <div>obj2: </div>
            <b ffm>{{ obj2 }}</b>
        </div>


    </section>
<?
$body = ob_get_clean();

print rb_tpl('page', 'page', array(
	//'pageTitle' => 'Vue-Env',
	'body' => $body,
	'webkit' => array(
		'vue-env'
	),
));