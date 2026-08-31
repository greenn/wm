_vue('s-icon', function(_log){

    var getSrc = function(ctx){
        var src = '';
        _log('getSrc', { ctx });
        if (ctx.hasOwnProperty('oi')) { //open-iconic
            if (ctx.png) {
                src = `/ib/open-iconic/png/${ctx.png}.png`;
            }
            if (ctx.svg) {
                src = `/ib/open-iconic/svg/${ctx.svg}.svg`;
                if (ctx.php) {
                    //src += '?' + ctx.php;
                    src += `.php?${ctx.php}`;
                }
            }
        }
        return src;
    }

    return {
        inheritAttrs: false,

        data: function(){
            if (!1) _log('data0', {
                props: _clearObject(this.$props),
                attrs: _clearObject(this.$attrs),
            });

            //var set = _.defaults({this.$props.set}, this.$attrs);

            var attrs = _pickAttrs(this.$attrs, ['cp', 'rst', 'r', 'a', 'title']);
            //_log('data-attrs', { attrs, attrs_0: _clone(attrs), clear_attrs: _clearObject(this.$attrs) });
            if (!attrs.hasOwnProperty('a')) attrs.r = true;

            return {
                alt: this.$attrs.alt,
                //attrClass: this.$attrs.class,
                cssClass: {},
                css: {},
                src: getSrc(this.$attrs),
                attrs: attrs,
                hover: false
            }
        },
        methods: {
            hoverIn: function(){
                this.css.opacity = '.5';
            },
            hoverOut: function(){
                this.css.opacity = '1';
            },
            mouseDown: function(){
                //_log('mouseDown', { 'css-0': this.$el.style, 'css-1': window.getComputedStyle(this.$el), 'css-2': this.$el.computedStyleMap() })
                this.css.top = '1px';
            },
            mouseUp: function(){
                this.css.top = '0px';
            },
        },
        mounted: function() {
            //var $node = $(this.$el)
        }
    }
})