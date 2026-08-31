<div class="box">
	<div class="cube-wrap">
		<div class="cube">
			<div class="front"> Front </div>
			<div class="back"> Back </div>
			<div class="top"> Top </div>
			<div class="bottom"> Bottom </div>
			<div class="left"> Left </div>
			<div class="right"> Right </div>
		</div>
	</div>
</div>



<style type="text/css">
.box {margin:auto auto; min-height:400px;}




.cube-wrap {
	margin-top: 250px;
	perspective: 1000px;
	perspective-origin: 50% 50%;
}
.cube {
	margin: auto;
	position: relative;
	height: 200px;
	width: 200px;
	-webkit-transform-style:preserve-3d;
	transform-style: preserve-3d;
}

.cube > div {
	position: absolute;
	box-sizing: border-box;
	/*padding: 10px;*/
	line-height:200px;
	text-align:center;
	height: 100%;
	width: 100%;
	opacity: 0.9;
	border: 1px solid #000;
	color: #000;
	font-weight:bold;
}
.front {
	-webkit-transform: translateZ(100px);
	transform: translateZ(100px);
	background-color:#00d7ff;
}

.back {
	-webkit-transform: translateZ(-100px) rotateY(180deg);
	transform: translateZ(-100px) rotateY(180deg);
	background-color:#e86836;
}

.right {
	-webkit-transform: rotateY(-270deg) translateX(100px);
	transform: rotateY(-270deg) translateX(100px);
	transform-origin: top right;
	background-color:#ffc900;
}

.left {
	-webkit-transform: rotateY(270deg) translateX(-100px);
	transform: rotateY(270deg) translateX(-100px);
	transform-origin: center left;
	background-color:#00ff73;
}

.top {
	-webkit-transform: rotateX(-270deg) translateY(-100px);
	transform: rotateX(-270deg) translateY(-100px);
	transform-origin: top center;
	background-color:#ff00f9;
}

.bottom {
	-webkit-transform: rotateX(270deg) translateY(100px);
	transform: rotateX(270deg) translateY(100px);
	transform-origin: bottom center;
	background-color:#7552bc;
}

@keyframes rotate {
	from {
		transform: rotateX(0deg) rotateY(0deg);
	}

	to {
		transform: rotateX(360deg) rotateY(360deg);
	}
}

.spincube {
	animation: rotate 20s infinite linear;
	-webkit-transform-style:preserve-3d;
	transform-style:preserve-3d
}
</style>


<style
	type="text/css"
	contenteditable="true"
	style="
        display: block;
        white-space: pre;
        border: 3px solid seagreen;
        background-color: lightyellow;
    "
>
.cube {
	transform:
	scaleX(1)
	scaleY(1)
	scaleZ(1)
	rotateX(0deg)
	rotateY(0deg)
	rotateZ(-32deg)
	translateX(1px)
	translateY(-1px)
	translateZ(-3px)
	skewX(0deg)
	skewY(0deg);
}
.cube-wrap {
	perspective: 1000px;
	perspective-origin: 50% 50%;
}
</style>