_vue('<?=basename(__FILE__, '.vue.js.inc')?>', function(_log, _cmd){
    return {
        _vue: {},

        props: ['tick'],
        data: function(){
            return {
                size: 5,
                pad: 2,

                width: 0,
                length: 0,
                points: [],
                ///point: 0,
                shift: 0,
            }
        },
        computed: {

        },
        methods: {

            updateWidth: function(){
                //_log('updateWidth', $(this.$refs['bar']).width())
                this.width = $(this.$refs['bar']).width();
                this.length = Math.ceil(this.width / (this.size + this.pad));
                this.syncShift();
            },
            nextPoint: function(){
                this.points.push({
                    title: this.points.length
                })
                this.syncShift();
                //_log('nextPoint', { point: this.points.length, l: this.length, shift: this.shift });
            },

            syncShift: function(){
                this.shift = Math.floor(this.points.length / this.length) * this.size;
            }
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