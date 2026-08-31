const MyComponent = {
    template: '#cmpt',
    setup(props, { expose }) {
        const count = ref(0)
        const reset = () => count.value = 0
        const increment = () => count.value++

        // Только метод reset будет доступен извне, например через $refs
        expose({
            reset
        })

        // Внутри у шаблона будет доступ к count и increment
        return { count, increment }
    }
}