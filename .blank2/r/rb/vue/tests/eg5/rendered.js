(function anonymous(
) {
    const _Vue = Vue

    return function render(_ctx, _cache) {
        with (_ctx) {
            const { resolveComponent: _resolveComponent, createVNode: _createVNode, renderList: _renderList, Fragment: _Fragment, openBlock: _openBlock, createElementBlock: _createElementBlock, createBlock: _createBlock, normalizeStyle: _normalizeStyle, createElementVNode: _createElementVNode, mergeProps: _mergeProps } = _Vue

            const _component_button_counter = _resolveComponent("button-counter")
            const _component_blog_post = _resolveComponent("blog-post")

            return (_openBlock(), _createElementBlock(_Fragment, null, [
                _createVNode(_component_button_counter),
                _createVNode(_component_button_counter),
                _createVNode(_component_button_counter),
                _createElementVNode("div", {
                    style: _normalizeStyle({ fontSize: postFontSize + 'em' })
                }, [
                    (_openBlock(true), _createElementBlock(_Fragment, null, _renderList(posts, (post) => {
                        return (_openBlock(), _createBlock(_component_blog_post, {
                            key: post.id,
                            title: post.title
                        }, null, 8 /* PROPS */, ["title"]))
                    }), 128 /* KEYED_FRAGMENT */))
                ], 4 /* STYLE */),
                (_openBlock(true), _createElementBlock(_Fragment, null, _renderList(posts, (post) => {
                    return (_openBlock(), _createBlock(_component_blog_post, {
                        key: post.id,
                        title: post.title
                    }, null, 8 /* PROPS */, ["title"]))
                }), 128 /* KEYED_FRAGMENT */)),
                _createVNode(_component_blog_post, _mergeProps(, {
                    onEnlargeText: $event => (postFontSize += 0.1)
                }), null, 16 /* FULL_PROPS */, ["onEnlargeText"])
            ], 64 /* STABLE_FRAGMENT */))
        }
    }
})