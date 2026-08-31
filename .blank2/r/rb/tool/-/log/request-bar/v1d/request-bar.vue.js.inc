_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){
    return {
        _vue: {},

        props: ['tick'],
        data: function(){
            return {
                width: 0,
                size: 5,
                pad: 2,
                lastFilledPoint: 0,
                length: 0,
                points: []
            }
        },
        computed: {

        },
        methods: {
            rebuildPoints: function(width){
                var relPos = (this.lastFilledPoint / this.length) || 0;
                this.length = _.floor(this.width / (this.size + this.pad));

                var curPos = this.lastFilledPoint = _.floor(relPos * this.length);

                _log('new points', { relPos, length: this.length, curPos })
                var range = _.range(this.length);
                this.points = _.transform(range, function(res, idx){
                    res.push({
                        isFilled: idx <= curPos
                    })
                }, []);
            },
            updateWidth: function(){
                //_log('updateWidth', $(this.$refs['bar']).width())
                this.width = $(this.$refs['bar']).width();
                this.rebuildPoints();
            },
            nextPoint: function(){
                var index = this.lastFilledPoint++;
                this.points[index].isFilled = true;
                if (index >= this.length) {
                    this.lastFilledPoint = 0;
                    this.rebuildPoints();
                }
            },
        },
        watch: {
            tick: function(value){
                //_log('w:tick', value);
            }
        },
        mounted: function() {
            var self = this;

            this.$watch(
                "$root.updateTime",
                function (newVal, oldVal) {
                    self.nextPoint()
                    //_log('w:updateTime', newVal);
                }
            );

            var debounceResizeEvent = _.debounce(function(){
                _log('resize')
                self.updateWidth()
            }, 200);

            $(window).resize(function(){
                debounceResizeEvent();
            });
            self.updateWidth()

        }
    }
})