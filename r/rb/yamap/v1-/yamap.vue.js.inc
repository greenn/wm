<?
$Self = _site::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));

rb('yamap', 'req_v2', _pro('yamap-key'), -10);

?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            //multiInstances: true,
            provide: [],
        },

        props: {
            title: String,
            polygon: Object,
            polygonStyle: Object,
            center: Object,
            size: Object,
            zoom: Number,
            type: String,
        },

        data(){
            //_log('data');
            return {

                address: '',
                geocoder: null,

                isMapLive: false,

                // Данные для карты
                map: {
                    type: 'yandex#hybrid',
                    /*
                        'yandex#map' — схема (обычная карта).
                        'yandex#satellite' — спутниковая карта.
                        'yandex#hybrid' — гибрид (спутник + схема).
                        'yandex#publicMap' — народная карта.
                        'yandex#publicMapHybrid' — народная карта + спутник.
                    */
                    'static-type': 'map', //sat,skl
                        /*
                            map —
                            sat — спутниковый слой.
                            skl — схема с названиями и контурными линиями (спутник + подписи).
                        * */



                    zoom: 18,
                    'static-zoom': 16,
                },
                // Данные для полигона


                currentZoom: undefined

            }
        },

        methods: {

            initMap() {
                // Создание карты
                this.map = new ymaps.Map("map", {
                    center: [this.center.latitude, this.center.longitude]
                    ///center: [55.751244, 37.618423], // Координаты центра карты (Москва)
                    zoom: 10
                });
                // Инициализация геокодера
                this.geocoder = new ymaps.geocode;
            },


            initLiveMap() {
                this.isMapLive = true;
                ymaps.ready(() => {

                    var map = this.mapInstance = new ymaps.Map(this.$refs.map, {
                        center: [this.center.latitude, this.center.longitude],
                        zoom: this.zoom || this.map.zoom,
                        type: this.mapType || this.map.type,
                    });



                    if (this.polygon) {
                        var polygonCoordinates = this.polygon.coordinates || this.polygon.coordinates_rev.map(coord => [coord[1], coord[0]]);

                        var polygon = new ymaps.Polygon([polygonCoordinates], {}, {
                            fillColor: this.polygonStyle.fillColor,
                            strokeColor: this.polygonStyle.color,
                            strokeWidth: this.polygonStyle.strokeWidth
                        });

                        map.geoObjects.add(polygon);

                        map.hint.open(polygonCoordinates[0], this.title);

                        map.events.add('boundschange', function () {
                            map.hint.close();
                        });


                        if (0) polygon.events.add('mouseenter', function (e) {
                            map.hint.open(e.get('coords'), this.title);
                        });

                        // Убираем hint при выходе мыши из полигона
                        if (0) polygon.events.add('mouseleave', function () {
                            map.hint.close();
                        });


                    }



                    // Добавление полигонов на карту
                    this.polygons.forEach(function (polygon) {
                        var myPolygon = new ymaps.Polygon([polygon.coordinates], {}, {
                            fillColor: polygon.fillColor,
                            strokeColor: polygon.color,
                            strokeWidth: polygon.strokeWidth
                        });
                        map.geoObjects.add(myPolygon);
                    });


                    this.geocoder = new ymaps.geocode;

                    map.events.add('boundschange', (event) => {
                        this.currentZoom = event.get('newZoom');
                    });



                });
            },

            setPolygon(){
                var styleCfg = {
                    'c': this.polygonStyle.color.replace('#', ''),
                    'w': this.polygonStyle.strokeWidth,
                    'f': this.polygonStyle.fillColor.replace('#', ''),
                }
                var stylesUri = _.map(styleCfg, function(value, key) {
                    return `${key}:${value}`;
                }).join(',');

                var polygonUri = '';


                var polygonCoordinates = this.polygon.coordinates_rev || this.polygon.coordinates.map(coord => [coord[1], coord[0]]);

                polygonUri = [
                    stylesUri,
                    polygonCoordinates.join(',')
                ].join(',')

                return polygonUri;

            }

        },

        computed: {
            staticUrl() {
                const baseUrl = 'https://static-maps.yandex.ru/1.x/';

                // Параметры запроса
                var params = {
                    l: this.map['static-type'],
                    size: `${this.map.size.width},${this.map.size.height}`,
                    z: this.map['static-zoom'],
                    ll: `${this.map.center.longitude},${this.map.center.latitude}`
                };

                if (this.polygon) {
                    // Формируем параметр pl для полигона
                    params.pl = this.setPolygon()
                }

                var queryString = _.map(params, function(value, key) {
                    var encodedValue = encodeURIComponent(value);
                    return `${key}=${encodedValue}`;
                }).join('&');


                return `${baseUrl}?${queryString}`;
            },


        },


        mounted() {
            // Инициализация карты после загрузки Vue
            //ymaps.ready(this.initMap);
            //this.initLiveMap();

        },
    }
})