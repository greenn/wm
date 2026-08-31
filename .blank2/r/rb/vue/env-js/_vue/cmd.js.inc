//вспомогательный хендлер,
// дополниьтельные функциии для управления создания декларации
var _cmd = {
    //useRouter: false,

    log: _log,
    counter: 0, /*полу-автоматически счётчик кол-ва инстансов
             0 - одиночное использование
             1 - включение инкримента

            oo-eg
			    iq/tool/css/calc-vu/calc-vu.vue.js.inc
			    rb/vue/test/slot/cmpt.vue.js.inc
        */
    curIndex: function(justGet){
        return justGet ? this.counter : this.counter++
    },

    addRoutes: function(){

    }
}