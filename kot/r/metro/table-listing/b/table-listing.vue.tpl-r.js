(function anonymous(
) {
    const _Vue = Vue
    const { createVNode: _createVNode, createElementVNode: _createElementVNode } = _Vue

    const _hoisted_1 = { class: "TL-w" }
    const _hoisted_2 = { class: "TL-table ft-small" }
    const _hoisted_3 = { class: "-bld" }
    const _hoisted_4 = ["onClick"]
    const _hoisted_5 = ["onClick"]

    return function render(_ctx, _cache) {
        with (_ctx) {
            const { toDisplayString: _toDisplayString, createElementVNode: _createElementVNode, resolveComponent: _resolveComponent, createVNode: _createVNode, renderList: _renderList, Fragment: _Fragment, openBlock: _openBlock, createElementBlock: _createElementBlock, normalizeClass: _normalizeClass } = _Vue

            const _component_table_handler = _resolveComponent("table-handler")
            const _component_busy_area = _resolveComponent("busy-area")
            const _component_modal_button = _resolveComponent("modal-button")

            return (_openBlock(), _createElementBlock("div", _hoisted_1, [
                _createElementVNode("pre", null, "totalItems: " + _toDisplayString(totalItems), 1 /* TEXT */),
                _createVNode(_component_table_handler, {
                    total: totalItems,
                    busy: busy
                }, null, 8 /* PROPS */, ["total", "busy"]),
                _createElementVNode("div", {
                    r: "",
                    osx: "",
                    class: _normalizeClass(["TL-table-w", { '-busy': busy }])
                }, [
                    _createVNode(_component_busy_area, {
                        a: "ltrb",
                        busy: busy,
                        onExtraClose: $event => (busy = false)
                    }, null, 8 /* PROPS */, ["busy", "onExtraClose"]),
                    _createElementVNode("table", _hoisted_2, [
                        _createElementVNode("tr", null, [
                            (_openBlock(true), _createElementBlock(_Fragment, null, _renderList([
                                { title: '' },
                                { title: 'ID' },
                                { title: 'Наименование' },
                                { title: 'Обновлено' },
                                { title: 'Статус' },
                                { title: '' },
                                { title: '' },
                                { title: '' },
                                { title: '' },
                            ], (th) => {
                                return (_openBlock(), _createElementBlock("th", _hoisted_3, [
                                    _createElementVNode("div", null, _toDisplayString(th.title), 1 /* TEXT */)
                                ]))
                            }), 256 /* UNKEYED_FRAGMENT */))
                        ]),
                        (_openBlock(true), _createElementBlock(_Fragment, null, _renderList(items, (item, index) => {
                            return (_openBlock(), _createElementBlock("tr", {
                                key: item.uid,
                                class: _normalizeClass([index % 2 ? '-odd' : '-even', { '-selected': tr_selected === index }]),
                                onClick: $event => (tr_selected = index)
                            }, [
                                _createElementVNode("td", null, [
                                    _createVNode(_component_modal_button, {
                                        item: item,
                                        onOnDelete: $event => ($emit('onDelete', $event)),
                                        onOnCopy: $event => (linkAdd($event))
                                    }, null, 8 /* PROPS */, ["item", "onOnDelete", "onOnCopy"])
                                ]),
                                _createElementVNode("td", null, [
                                    _createElementVNode("div", null, [
                                        _createElementVNode("a", {
                                            class: "link",
                                            onClick: $event => (linkRel(item.uid))
                                        }, _toDisplayString(item.uid), 9 /* TEXT, PROPS */, _hoisted_5)
                                    ])
                                ]),
                                _createElementVNode("td", null, _toDisplayString(item.title), 1 /* TEXT */),
                                _createElementVNode("td", null, _toDisplayString(item.date), 1 /* TEXT */),
                                _createElementVNode("td", null, _toDisplayString(item.aprooved ? 'на согласовании' : 'не согласован'), 1 /* TEXT */),
                                _createElementVNode("td", null, _toDisplayString(item.type), 1 /* TEXT */),
                                _createElementVNode("td", null, _toDisplayString(item.aim), 1 /* TEXT */),
                                _createElementVNode("td", null, _toDisplayString(item.name), 1 /* TEXT */),
                                _createElementVNode("td", null, _toDisplayString(item.channel), 1 /* TEXT */)
                            ], 10 /* CLASS, PROPS */, _hoisted_4))
                        }), 128 /* KEYED_FRAGMENT */))
                    ])
                ], 2 /* CLASS */),
                _createVNode(_component_table_handler, {
                    total: totalItems,
                    busy: busy
                }, null, 8 /* PROPS */, ["total", "busy"])
            ]))
        }
    }
})