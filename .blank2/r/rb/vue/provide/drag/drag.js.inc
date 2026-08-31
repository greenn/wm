

_vue.provider['__drag'] = function(__cfg){
    //var _store = __cfg.store ? ['drag'] : []

    var vueCfg = {};
    if (__cfg.store) vueCfg.store = ['drag'];

    return {
        _vue: vueCfg,

        data() {
            return {
                drag: {
                    timer: null,
                    delay: 60,
                    wasDragged: false,
                    isDragging: false,
                    startX: 0,
                    startY: 0,
                    startLeft: 0,
                    startTop: 0,
                    left: 0,
                    top: 0
                }
            }
        },
        computed: {
            dragStyle() {
                return {
                    position: 'absolute',
                    left: `${this.drag.left}px`,
                    top: `${this.drag.top}px`
                }
            }
        },
        methods: {
            dragStart(e) {
                if (this.drag.timer) {
                    clearTimeout(this.drag.timer)
                }

                this.drag.startX = e.clientX
                this.drag.startY = e.clientY
                this.drag.startLeft = this.drag.left
                this.drag.startTop = this.drag.top

                this.drag.timer = setTimeout(() => {
                    this.drag.isDragging = true
                    this.drag.wasDragged = false
                    document.addEventListener('mousemove', this.dragging)
                }, this.drag.delay)

                document.addEventListener('mouseup', this.cancelDragStart)
            },
            cancelDragStart() {
                if (this.drag.timer) {
                    clearTimeout(this.drag.timer)
                    this.drag.timer = null
                }
                document.removeEventListener('mouseup', this.cancelDragStart)
            },

            dragging(e) {
                if (!this.drag.isDragging) return

                this.drag.wasDragged = true
                const dx = e.clientX - this.drag.startX
                const dy = e.clientY - this.drag.startY

                this.drag.left = this.drag.startLeft + dx
                this.drag.top = this.drag.startTop + dy
            },
            dragStop(e) {
                this.cancelDragStart()
                if (this.drag.isDragging) {
                    this.drag.isDragging = false
                    document.removeEventListener('mousemove', this.dragging)
                }
            },
            dragClick(cb) {
                if (!this.drag.wasDragged) {
                    cb.call(this)
                }
                this.drag.wasDragged = false
            },
        },
        mounted() {
            // Если нужно установить начальную позицию
            //const rect = this.$refs.container.getBoundingClientRect()
            //this.drag.left = rect.left
            //this.drag.top = rect.top
        },
    }
}