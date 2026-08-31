<?
//https://v3.ru.vuejs.org/ru/guide/transitions-state.html#%D0%B4%D0%B8%D0%BD%D0%B0%D0%BC%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%B8%D0%B5-%D0%BF%D0%B5%D1%80%D0%B5%D1%85%D0%BE%D0%B4%D1%8B-%D0%BC%D0%B5%D0%B6%D0%B4%D1%83-%D1%81%D0%BE%D1%81%D1%82%D0%BE%D1%8F%D0%BD%D0%B8%D1%8F%D0%BC%D0%B8
//https://codepen.io/team/Vue/pen/a8e00648d4df6baa1b19fb6c31c8d17e
?>

var defaultSides = 10;
var stats = Array.apply(null, { length: defaultSides }).map(function () {
    return 100;
});

var Demo = {
    data: function data() {
        return {
            stats: stats,
            points: generatePoints(stats),
            sides: defaultSides,
            minRadius: 50,
            interval: null,
            updateInterval: 500 };
    },

    watch: {
        sides: function sides(newSides, oldSides) {
            var sidesDifference = newSides - oldSides;
            if (sidesDifference > 0) {
                for (var i = 1; i <= sidesDifference; i++) {
                    this.stats.push(this.newRandomValue());
                }
            } else {
                var absoluteSidesDifference = Math.abs(sidesDifference);
                for (var i = 1; i <= absoluteSidesDifference; i++) {
                    this.stats.shift();
                }
            }
        },
        stats: function stats(newStats) {
            gsap.to(this.$data, this.updateInterval / 1000, {
                points: generatePoints(newStats) });
        },
        updateInterval: function updateInterval() {
            this.resetInterval();
        }
    },

    mounted: function mounted() {
        this.resetInterval();
    },

    methods: {
        randomizeStats: function randomizeStats() {
            var vm = this;
            this.stats = this.stats.map(function () {
                return vm.newRandomValue();
            });
        },
        newRandomValue: function newRandomValue() {
            return Math.ceil(this.minRadius + Math.random() * (100 - this.minRadius));
        },
        resetInterval: function resetInterval() {
            var vm = this;
            clearInterval(this.interval);
            this.randomizeStats();
            this.interval = setInterval(function () {
                vm.randomizeStats();
            }, this.updateInterval);
        }
    } };

Vue.createApp(Demo).mount("#demo");

function valueToPoint(value, index, total) {
    var x = 0;
    var y = -value * 0.9;
    var angle = Math.PI * 2 / total * index;
    var cos = Math.cos(angle);
    var sin = Math.sin(angle);
    var tx = x * cos - y * sin + 100;
    var ty = x * sin + y * cos + 100;
    return { x: tx, y: ty };
}

function generatePoints(stats) {
    var total = stats.length;
    return stats.map(function (stat, index) {
        var point = valueToPoint(stat, index, total);
        return point.x + "," + point.y;
    }).join(" ");
}