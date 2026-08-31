<?
//https://stackoverflow.com/questions/64184203/vuejs-transition-css-only-slide-down
?>

<div>
    <button @click="jsOpen = !jsOpen">Open JS list</button>
    <transition
            v-on:before-enter="beforeEnter"
            v-on:enter="enter"
            v-on:after-enter="afterEnter"
            v-on:enter-cancelled="enterCancelled"
            v-on:before-leave="beforeLeave"
            v-on:leave="leave"
            v-on:after-leave="afterLeave"
            v-on:level-cancelled="leaveCancelled"
            v-bind:css="false"
    >
        <ul v-if="jsOpen" class="mt-2 text-sm flex flex-col space-y-2">
            <li v-for="i in 10" :key="i">item-{{ i }}</li>
        </ul>
    </transition>
</div>
</template>

<script>
    export default {
        ...
            methods: {
        beforeEnter(el) {
            el.style.height = 0;
            el.style.overflow = "hidden";
        },
        enter(el, done) {
            const increaseHeight = () => {
                if (el.clientHeight < el.scrollHeight) {
                    const height = `${parseInt(el.style.height) + 5}px`;
                    el.style.height = height;
                } else {
                    clearInterval(this.enterInterval);
                    done();
                }
            };
            this.enterInterval = setInterval(increaseHeight, 10);
        },
        afterEnter(el) {},
        enterCancelled(el) {
            clearInterval(this.enterInterval);
        },
        beforeLeave(el) {},
        leave(el, done) {
            const decreaseHeight = () => {
                if (el.clientHeight > 0) {
                    const height = `${parseInt(el.style.height) - 5}px`;
                    el.style.height = height;
                } else {
                    clearInterval(this.leaveInterval);
                    done();
                }
            };
            this.leaveInterval = setInterval(decreaseHeight, 10);
        },
        afterLeave(el) {},
        leaveCancelled(el) {
            clearInterval(this.leaveInterval);
        },
    },
    };
</script>

<style type="text/css">

    .scale-enter-active,
    .scale-leave-active {
        transform-origin: top;
        transition: transform 0.3s ease-in-out;
    }

    .scale-enter-to,
    .scale-leave-from {
        transform: scaleY(1);
    }

    .scale-enter-from,
    .scale-leave-to {
        transform: scaleY(0);
    }

    .slidedown-enter-active,
    .slidedown-leave-active {
        transition: max-height 0.5s ease-in-out;
    }

    .slidedown-enter-to,
    .slidedown-leave-from {
        overflow: hidden;
        max-height: 1000px;
    }

    .slidedown-enter-from,
    .slidedown-leave-to {
        overflow: hidden;
        max-height: 0;
    }
</style>
