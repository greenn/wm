<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('qtpl.class');
$selfDir = dirname(__FILE__);


?>
<head>
    <title>App with VueRoot</title>

    <? include '../js.scripts.inc'?>

    <script>
        var user = {
            au: 1
        }

    </script>

    <script>
        const Root = VueRoot;
        var _log = Log.for('DBG');
        Root.init(function(_log){
            //декла
            /*
                initApp(%this_fn)
                RootDecl(%this_fn)
                _extendDecl(%RootDecl, %this_fn, %args = [_log])
                VueDecl.extend(%RootDecl, %this_fn(%args))
                == ResDecl
            */
            _log('I', { self: this, App: _clone(App) })
        }, true, function(){
            //routes ()
            var self = this;
            _log('II', { self,
                Login1: self.getDecl('login'),
                Login2: self.getDeclComponent('login'),
                Login3: self.getComponent('login'),
            })
            return false;
        }, function(){
            //on mount
            var self = this;
            _log('III', { self: this,
                Login1: self.getDecl('login'),
                Login2: self.getDeclComponent('login'),
                Login3: self.getComponent('login'),
            })
        });


    </script>


	<?=qtpl::vue_html("$selfDir/app") ?>
	<?=qtpl::vue_html("$selfDir/login") ?>
	<?=qtpl::vue_html("$selfDir/dashboard") ?>


</head>


<body style="background-color: lightpink">
    <app></app>
</body>