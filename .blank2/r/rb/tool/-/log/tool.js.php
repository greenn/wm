<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _rw::name('tool-css');
headers('js', 'utf8', 'nosniff', etag::ctx(
	//etag::extra(),
	__FILE__
), SITE_CACHE);

//wjs::req('storage');
//site_js::req_name('jquery');
?>

vue_app(function(_log){
    //_log('0', _log.nextIndex(), _log.nextIndex());
    _log.set_({
        'api/dataUpdate': 0
    })

    var startTime1 = <?=microtime(true)?>;
    var startTime2 = (new Date()).getTime()/1000;
    var startTime3 = performance.timeOrigin / 1000; //performance.now() / 1000
    var startTime4 = moment().valueOf();
    var startTime5 = moment().unix();
    //_log('startTime', [startTime1, startTime2, startTime3, startTime4, startTime5]);

    //step: инициализация значения для локального хранения
    //Store.dbg();
    //Store.remove(['log-tool', 'startTime'])
    var _startTime = Store.observable(['log-tool', 'startTime'], startTime5)

    return {
        _vue: {
            store: {
                keys: ['updateInterval'],
                //propIndex: '_index' //_storeIndex -  для повторяющихся компонентов
            }
        },

        data: function(){
            //_log('data');
            return {
                logData: {},

                startTime: _startTime(),
                updateTime: _startTime(),
                passedTime: '',

                //updateInterval: Store.get(['log-tool', 'updateInterval']) || 0
                updateInterval: 0,
                _updateTimeout: 0
            }
        },
        methods: {
            dataUpdate: function(){
                var self = this;
                Api.request.get('rw/tool-log/data', { tmp: this.updateTime }, function(response){
                    _log('api/dataUpdate', { response })
                    self.updateTime = response.updateTime;
                    _.each(response.list, function(item, key){
                        self.logData[key] = item;
                    })

                    //step: go next round
                    self._updateTimeout = setTimeout(function(){
                        self.dataUpdate();
                    }, self.updateInterval)
                })
            },
            testLog: function(){
                Api.request.get('rw/tool-log/test', { tmp: moment().unix() }, function(response){
                    _log('api/testLog', response)
                })
            },
            resetStartTime: function(){
                this.startTime = moment().unix();
            },

            updatePassedTime: function(){
               this.passedTime = moment(this.startTime * 1000).fromNow();
            },

            /*goUpdate: function(){
                clearInterval(this._updateInterval);
            }*/
        },
        watch: {
            updateTime: function(value){
                //_log('w:updateTime', value);
            },

            startTime: function(value){
                //step: при изменении значения, обновляем значение в локальной базе
                //_log('w:startTime', value)
                _startTime(value)
            },

            logData: {
                deep: true,
                handler: function(){
                    //_log('w:logData', _.size(this.logData))
                }
            }
        },
        computed: {
            startTimeFormat: function(){
                return moment(this.startTime * 1000).format('HH:mm:ss YYYY/MMM/DD');
            },
        },
        //components: {},
        mounted: function() {
            var self = this;

            this.dataUpdate();

            self.updatePassedTime();
            setInterval(function(){
                self.updatePassedTime()
            }, 1000)
        }
    }

}, function(){
    App = _App.mount('#app-tool');
})

