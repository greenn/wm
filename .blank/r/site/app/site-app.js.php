<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
	'headers'//,
    //'dirUrl'
);
$Self = _site::self();
$n = $Self::nc();

//$baseUri = gt('base', '/');
$mq = gt_on('mq', true);

headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra($mq),
	__FILE__
), SITE_CACHE);

$Self::req_js(1, 'site-app-env');
$Self::req_js(1, 'site-app.vue-ext');
js::wreq('ppath.jq');
//js::wreq('mq.jq');

############# content
//$Self::req_vue('http-403');
//$Self::req_vue('http-404');

//_acc::req_vue('app-titul', 'titul-test', array(), 'titul-test');

//подгрузка модулей на страницу
//_kmod::req_vue(-1, 'site-menu', 'site-menu', array(), 'site-menu');


############# /content
?>
_r.vue.init({
    mount: 'BODY',

    use: {
        'vuetify': Vuetify.createVuetify(), <?// tooltip ?>
        //'vue-material': VueMaterial
    },



    decl: function(_log){

        return {
            _vue: {
                provide: [
                    //'aaa',
                    //'aaaa',
                    { 'mqr': {} }
                ],
            },

            data(){
                return {
                    //pageTitle: '…',
                    mqList: [],

                    footerContactTitleHover: false,
                    footerContactTitleOpacityClass: '-op0',
                    //footerRightHandHover: false,
                    showContacts: {},
                    showSearchBox: false,
                }
            },

            methods: {
                closePreloader(){
                    //_log('closePreloader', { ref:  })
                    $(this.$refs.preloader).hide();
                },

                //@mqr
                    //initMQAutoResize
                    //MQAutoResize
                    //splitValueAndUnit
                    //convertStringToTypedValue
                    //isNumeric

                syncFooterContactTitleOpacityClass(event){

                    var titleRect = this.$refs.footerContactTitle.getBoundingClientRect()
                    var handRect = this.$refs.footerRightHand.getBoundingClientRect()
                    var x1 = titleRect.right;
                    var x2 = handRect.right;

                    var xHand = x2 - event.clientX;
                    var xTotal = x2 - x1;
                    var pctMove = xHand / xTotal;

                    //pctMove = Math.floor(pctMove * 100);

                    var minOp = .4;
                    var op = _.clamp(pctMove * 100, minOp * 100, 100); // Выбираем значение в диапазоне от minOp до 100
                    //var op = Math.max(Math.floor(pctMove * 100), minOp * 100); //~ same
                    op = Math.ceil(op / 5) * 5; // Шаг 5 - округляем до ближайшего числа, кратного 5

                    this.footerContactTitleOpacityClass = `-op${op}`;

                     //_log('syncFooterContactTitleOpacityClass', pctMove, this.footerContactTitleOpacityClass)
                },


                //@mousemove="hoverEf1"

                hoverEf1(event){
                    var node = event.target;
                    var $node = $(node);
                    var w = window.innerWidth / 2;
                    w = $node.innerWidth(); //node.clientWidth
                    //w = $node.outerWidth(); //node.offsetWidth

                    let xAxis = (w / 2 - event.clientX) / 25;
                    let yAxis = (w / 2 - event.clientY) / 25;

                    xAxis = (event.clientX - window.innerWidth / 2) / 20;
                    yAxis = (event.clientY - window.innerHeight / 2) / 20;


                    if(1) _.once(function(){
                        _log('hoverEf1::INFO', { transform: $node.css("transform") })
                    })

                    _log('hoverEf1', $node.ppath5())
                    $node.css("transform", `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`);


                },


                hoverEf2Reset(event){},

                // @mousemove="hoverEf2"
                hoverEf2(event){
                    var containerNode = event.target;
                    var $container = $(containerNode);

                    var nodeSr = $container.attr('hover-obj');
                    var $node = nodeSr ? $(nodeSr, $container) : $container

                    const multiple = 10;
                    let box = $node[0].getBoundingClientRect();
                    var x = event.clientX;
                    var y = event.clientY;
                    const calcX = -(y - box.y - box.height / 2) / multiple;
                    const calcY = (x - box.x - box.width / 2) / multiple;
                    const percentage = parseInt((x - box.x) / box.width * 1000) / 10;

                    $node.css("transform", "rotateX(" + calcX + "deg) " + "rotateY(" + calcY + "deg)");


                    $container.on('mouseleave', function(){
                        $node.css("transform", 'rotateX(0) rotateY(0)');
                    })

                },

                clickFake(e){
                    //_log('clickFake', { e1: e.target, e2: e.currentTarget })
                    var $node = $(e.currentTarget);
                    $node.addClass('shake-404');
                    setTimeout(function(){
                        $node.removeClass('shake-404');
                    }, 500)

                },

                showOrderPopup(){

                },

                redirectTo(addr) {
                    //_log('redirectTo', { addr })
                    window.location.href = addr;
                }


            },

            computed: {
                ncApp: function(){
                    return {
                        //'-min': this.minSide,
                    }
                },
                isLogined(){
                    return false;
                }
            },

            watch: {

                showContacts: {
                    deep: true,
                    handler(newVal, oldVal) {
                        this.initMQAutoResize();
                    },
                },

            },

            mounted(){



                //window.onload = this.checkContentHeight;

                //_log('mounted/search-box', [])
                if (_.startsWith(location.pathname, '<?=page('search', 'makeLink')?>')) {
                    this.showSearchBox = true;
                }


                var mq = <?=var_export($mq)?>;
                if (mq) this.initMQAutoResize();


                AOS.init(
                    {
                        "easing": "ease-out-back",
                        "duration": 1000,
                        //"apos": 'bottom',
                        "offset": -100,

                        "mirror": false,
                        "once": true
                    }
                )

            }

        }
    }

});