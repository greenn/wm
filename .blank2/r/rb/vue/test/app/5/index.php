<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('qtpl.class');
$selfDir = dirname(__FILE__);


?>
<head>
    <title>VueRoot</title>

    <? include 'js.scripts.inc'?>

    <script>
        var user = {
            au: 1
        }
    </script>

    <script>
        const Root = VueRoot;
        Root.init(function(_log){
            return {
                data: function(){
                    return {
                        content: '-',
                        contentCmpt: 'atext',
                    }
                },

                methods: {
                    setContent: function(){
                        this.content = '11';
                    },

                    setContentCmpt: function(){
                        //Root.getComponent('extra')
                        this.contentCmpt = 'extra';
                    },

                    setContentCmpt2: function(){
                        var declExtra2 = Root.getDecl('extra', {
                            data: function(){
                                return { value: '-extra2-' }
                            },
                            mounted: function(){
                                Root.saveComponent('extra2', this);
                            }
                        });

                        _log('declExtra2', { declExtra2 });

                        //Root.addComponent('extra2', declExtra2);

                        this.contentCmpt = declExtra2;

                    },

                    loadContentCmpt: function(){
                        var self = this;
                        Root.loadComponent('rb/vue/test/app/5/extra', function(){
                            //_log('loadContentCmpt/res', { response })
                            //var Extra = Root.getDecl('extra');

                            var declExtra3 = Root.getDecl('extra', {
                                data: function(){
                                    return { value: '-extra3-' }
                                },
                                mounted: function(){
                                    Root.saveComponent('extra3', this);
                                }
                            });

                            _log('declExtra3', { declExtra3 });


                            self.contentCmpt = declExtra3;

                        })
                    }

                },
                mounted: function(){
                    _log('mounted 2');
                }
            }
        }, true);
    </script>

	<?=qtpl::vue_html("$selfDir/atext") ?>
	<?//=qtpl::vue_html("$selfDir/extra") ?>


	<?//= qtpl::vue_html("$selfDir/acontent") ?>

</head>


<body style="background-color: lightcyan">
    <div class="app">
        <h1 v-html="'Headline'"></h1>
        <button @click="setContent">setContent</button>
        <button @click="setContentCmpt">setContentCmpt</button>
        <button @click="loadContentCmpt">loadContentCmpt</button>
        <button @click="setContentCmpt2">setContentCmpt2</button>


        <atext></atext>
        <extra2></extra2>

        <h2>Content</h2>
        <div>{{ content }}</div>

        <h2>contentCmpt</h2>
        <component :is="contentCmpt"></component>



    <?/*
        <div atext zp3>
            <button @click="atext != atext">atext</button>
            <atext v-if="is('atext')">atext</atext>
            <atext v-if="atext">atext</atext>
        </div>
        <div acontent zp2>
            <acontent>acontent</acontent>
        </div>
        <div account z5>
            <account>account</account>
        </div>
        <div external zp4>
            <external>external</external>
        </div>
        <div error zp1>
            <error>error</error>
        </div>
    */?>

    </div>
</body>