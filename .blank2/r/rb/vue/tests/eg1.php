<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

?>

<div id="hello-vue" class="demo">
	{{ message }}
</div>

<style type="text/css">
	.demo {
		font-family: sans-serif;
		border: 1px solid #eee;
		border-radius: 2px;
		padding: 20px 30px;
		margin-top: 1em;
		margin-bottom: 40px;
		user-select: none;
		overflow-x: auto;
	}
</style>

<script src="/js/vue/3.2.20/vue.global.js"></script>

<script>
    const HelloVueApp = {
        data() {
            return {
                message: 'Hello Vue!!!'
            }
        }
    }

    Vue.createApp(HelloVueApp).mount('#hello-vue')
</script>
