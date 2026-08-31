

_vue.provider['__drozd-pick'] = function(__cfg){
    var vueCfg = {
        provide: ['range', 'makeRange']
    };

    if (__cfg.store) vueCfg.store = [
        'pickOpt',
        'pickSelected',
        'pickLevels',
        'pickLevelUsage',
        'pickLevelUsageInited',
    ];

    return {
        _vue: vueCfg,

        props: ['pick'],
        emits: ['pick'],

        data(){
            //this.clog('data/0', this);
            return {
                pickOpt: {
                    'hover': false,
                },
                pickSelected: undefined,
                pickHovered: undefined,
                pickLevels: {},
                pickLevelUsage: {},
                pickLevelUsageInited: {},
                //hotkeysEnabled: true
            }
        },

        methods: {
            pickChange(cname){
                if (!cname) cname = this.pickSelected;
                var color = cname ? this.pick[cname] : 'inherit';

                //this.clog('pickChange', { color, '$props.target': this.$props.target(), target: this.target() }, { '$props.target': this.$props.target(), target: this.target() })

                if (this.target) {
                    //this.clog('pickChange/target');
                    var node = this.target();
                    node.style.backgroundColor = color
                }
                var ctx = { cname, color };
                if (this.target) ctx.node = this.target();

                this.$emit('pick', { cname, color })
            },


            getNextPickKey(pos, relKey) {
                if (!relKey) relKey = this.pickSelected;
                var currentIndex = _.indexOf(this.pickKeys, relKey);
                if (currentIndex > -1) { //here: текущий ключ получен
                    var nextKey = this.pickKeys[currentIndex + pos];
                    return nextKey || relKey; //here: следующий ключ получен || нет (останавливаемся на текущем)
                } else {
                    return this.pickKeys[0];
                }
            },

            getNextPickKeyByLevel(pos) {
                let nextKey = this.pickSelected;
                let limKey = pos > 0 ? _.last(this.pickKeys) : _.first(this.pickKeys);

                while (nextKey !== limKey) {
                    nextKey = this.getNextPickKey(pos, nextKey);

                    // Проверяем уровень ключа
                    const level = this.pickLevels[nextKey];

                    // Если уровень находится в списке разрешенных, возвращаем этот ключ
                    if (this.pickLevelUsage[level]) {
                        return nextKey;
                    }
                }

                // Если не найден подходящий ключ, возвращаем текущий
                return this.pickSelected;
            },

            //подсчёт кол-во элементов с максимальным уровнем
            pickMaxLevelCount(lev) {
                return _.filter(_.values(this.pickLevels), value => value === lev).length;
            },
            
            setPickLevel(inc){

                var cname = this.pickSelected;
                //this.clog('setPickLevel', { inc, cname, name2: this.name2, pickLevels: this.pickLevels })
                if (cname) {
                    var newLevel = this.pickLevels[cname] + inc;
                    if(0) this.clog('setPickLevel', {
                        newLevel: this.pickMaxLevelCount(newLevel),
                        pickMaxLevel: this.pickMaxLevelCount(this.pickMaxLevel),
                    })
                    if (newLevel > this.pickMaxLevel) {
                        if (this.pickMaxLevelCount(this.pickMaxLevel) > 1) {
                            newLevel = this.pickMaxLevel + 1
                        } else {
                            newLevel = this.pickMaxLevel
                        }
                    }
                    if (newLevel < 1) {
                        newLevel = 1;
                    }
                    this.clog('setPickLevel/2', { newLevel, inc, cname, nameIndex: this.name2, pickLevels: this.pickLevels })
                    this.pickLevels[cname] = newLevel;
                }

            },

            bindHotkeys(event) {
                if (this.hotkeysEnabled === false) return;

                //this.clog('bindHotkeys', { key: event.key });
                switch(event.key) {
                    case 'ArrowLeft':
                        //this.pickSelected = this.getNextPickKey(-1);
                        this.pickSelected = this.getNextPickKeyByLevel(-1);
                        break;
                    case 'ArrowRight':
                        //this.pickSelected = this.getNextPickKey(1);
                        this.pickSelected = this.getNextPickKeyByLevel(1);
                        break;
                    case 'ArrowUp':
                        this.setPickLevel(-1);
                        break;
                    case 'ArrowDown':
                        this.setPickLevel(1);;
                        break;
                    case 'h':
                        this.pickOpt.hover = !this.pickOpt.hover;
                        break;
                }
            },
        //@utils/range

        },

        watch: {
            /*pickLevels: {
                deep: true,
                handler(newValue, oldValue) {
                    this.clog('w:pickLevels', { nameIndex: this.name2 })
                }
            },*/

            pickSelected(cname){
                this.pickChange(cname);
            },

            pick: {
                immediate: true, // это позволит выполнить обработку сразу при монтировании компонента
                handler(pickList) {
                    //this.clog('w:pick', { nameIndex: this.name2, pickLevels: this.pickLevels })
                    //case: когда нет данных в store
                    if (_.isEmpty(this.pickLevels)) {
                        this.pickLevels = _.mapValues(pickList, function() {
                            return 1;
                        });
                    }
                }
            },
            pickMaxLevel(newVal, prevVal){
                //if (newVal > prevVal)
                for (var lev = 1; lev <= newVal; lev++) {
                    if (!this.pickLevelUsageInited[lev]) {
                        this.pickLevelUsageInited[lev] = true;
                        this.pickLevelUsage[lev] = true;
                    }
                }
            },
        },

        computed:{
            pickKeys(){
                return _.keys(this.pick);
            },

            pickMaxLevel(){
                return _.max(_.values(this.pickLevels));
            },
        },

        mounted() {

            if(0) this.clog('mounted', {
                'pickSelected': this.pickSelected,
                'pickOpt': this.pickOpt,
                'pickLevelUsage': this.pickLevelUsage,
                'pickLevelUsageInited': this.pickLevelUsageInited,
            }, {})

            if (this.pickSelected) { //ak immediate: ручной запуск w:pickSelected в mounted,
                // т.к. pr immediate: true запускается до mounted
                // a handler появляется из-за store r/rb/vue/env-js/_vue/decl-store.js.inc:90
                //this.$options.watch.pickSelected.handler.call(this, this.pickSelected);

                this.pickChange();
            }

            //this.clog('@drozd-pick/')
            window.addEventListener('keydown', this.bindHotkeys)
        }
    }
}