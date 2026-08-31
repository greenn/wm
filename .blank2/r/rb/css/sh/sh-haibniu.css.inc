<? //https://codepen.io/haibnu/pen/FxGsI?>
/*==================================================
 * Effect 1
 * ===============================================*/
.sh-h1{
    -webkit-box-shadow: 0 10px 6px -6px #777;
    -moz-box-shadow: 0 10px 6px -6px #777;
    box-shadow: 0 10px 6px -6px #777;
}

/*==================================================
 * Effect 2
 * ===============================================*/
.sh-h2
{
    position: relative;
}
.sh-h2:before, .sh-h2:after
{
    z-index: -1;
    position: absolute;
    content: "";
    bottom: 15px;
    left: 10px;
    width: 50%;
    top: 80%;
    max-width:300px;
    background: #777;
    -webkit-box-shadow: 0 15px 10px #777;
    -moz-box-shadow: 0 15px 10px #777;
    box-shadow: 0 15px 10px #777;
    -webkit-transform: rotate(-3deg);
    -moz-transform: rotate(-3deg);
    -o-transform: rotate(-3deg);
    -ms-transform: rotate(-3deg);
    transform: rotate(-3deg);
}
.sh-h2:after
{
    -webkit-transform: rotate(3deg);
    -moz-transform: rotate(3deg);
    -o-transform: rotate(3deg);
    -ms-transform: rotate(3deg);
    transform: rotate(3deg);
    right: 10px;
    left: auto;
}

/*==================================================
 * Effect 3
 * ===============================================*/
.sh-h3
{
    position: relative;
}
.sh-h3:before
{
    z-index: -1;
    position: absolute;
    content: "";
    bottom: 15px;
    left: 10px;
    width: 50%;
    top: 80%;
    max-width:300px;
    background: #777;
    -webkit-box-shadow: 0 15px 10px #777;
    -moz-box-shadow: 0 15px 10px #777;
    box-shadow: 0 15px 10px #777;
    -webkit-transform: rotate(-3deg);
    -moz-transform: rotate(-3deg);
    -o-transform: rotate(-3deg);
    -ms-transform: rotate(-3deg);
    transform: rotate(-3deg);
}

/*==================================================
 * Effect 4
 * ===============================================*/
.sh-h4
{
    position: relative;
}
.sh-h4:after
{
    z-index: -1;
    position: absolute;
    content: "";
    bottom: 15px;
    right: 10px;
    left: auto;
    width: 50%;
    top: 80%;
    max-width:300px;
    background: #777;
    -webkit-box-shadow: 0 15px 10px #777;
    -moz-box-shadow: 0 15px 10px #777;
    box-shadow: 0 15px 10px #777;
    -webkit-transform: rotate(3deg);
    -moz-transform: rotate(3deg);
    -o-transform: rotate(3deg);
    -ms-transform: rotate(3deg);
    transform: rotate(3deg);
}

/*==================================================
 * Effect 5
 * ===============================================*/
.sh-h5
{
    position: relative;
}
.sh-h5:before, .sh-h5:after
{
    z-index: -1;
    position: absolute;
    content: "";
    bottom: 25px;
    left: 10px;
    width: 50%;
    top: 80%;
    max-width:300px;
    background: #777;
    -webkit-box-shadow: 0 35px 20px #777;
    -moz-box-shadow: 0 35px 20px #777;
    box-shadow: 0 35px 20px #777;
    -webkit-transform: rotate(-8deg);
    -moz-transform: rotate(-8deg);
    -o-transform: rotate(-8deg);
    -ms-transform: rotate(-8deg);
    transform: rotate(-8deg);
}
.sh-h5:after
{
    -webkit-transform: rotate(8deg);
    -moz-transform: rotate(8deg);
    -o-transform: rotate(8deg);
    -ms-transform: rotate(8deg);
    transform: rotate(8deg);
    right: 10px;
    left: auto;
}

/*==================================================
 * Effect 6
 * ===============================================*/
.sh-h6
{
    position:relative;
    -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
    -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
    box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
}
.sh-h6:before, .sh-h6:after
{
    content:"";
    position:absolute;
    z-index:-1;
    -webkit-box-shadow:0 0 20px rgba(0,0,0,0.8);
    -moz-box-shadow:0 0 20px rgba(0,0,0,0.8);
    box-shadow:0 0 20px rgba(0,0,0,0.8);
    top:50%;
    bottom:0;
    left:10px;
    right:10px;
    -moz-border-radius:100px / 10px;
    border-radius:100px / 10px;
}
.sh-h6:after
{
    right:10px;
    left:auto;
    -webkit-transform:skew(8deg) rotate(3deg);
    -moz-transform:skew(8deg) rotate(3deg);
    -ms-transform:skew(8deg) rotate(3deg);
    -o-transform:skew(8deg) rotate(3deg);
    transform:skew(8deg) rotate(3deg);
}

/*==================================================
 * Effect 7
 * ===============================================*/
.sh-h7
{
    position:relative;
    -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
    -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
    box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
}
.sh-h7:before, .sh-h7:after
{
    content:"";
    position:absolute;
    z-index:-1;
    -webkit-box-shadow:0 0 20px rgba(0,0,0,0.8);
    -moz-box-shadow:0 0 20px rgba(0,0,0,0.8);
    box-shadow:0 0 20px rgba(0,0,0,0.8);
    top:0;
    bottom:0;
    left:10px;
    right:10px;
    -moz-border-radius:100px / 10px;
    border-radius:100px / 10px;
}
.sh-h7:after
{
    right:10px;
    left:auto;
    -webkit-transform:skew(8deg) rotate(3deg);
    -moz-transform:skew(8deg) rotate(3deg);
    -ms-transform:skew(8deg) rotate(3deg);
    -o-transform:skew(8deg) rotate(3deg);
    transform:skew(8deg) rotate(3deg);
}

/*==================================================
 * Effect 8
 * ===============================================*/
.sh-h8
{
    position:relative;
    -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
    -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
    box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
}
.sh-h8:before, .sh-h8:after
{
    content:"";
    position:absolute;
    z-index:-1;
    -webkit-box-shadow:0 0 20px rgba(0,0,0,0.8);
    -moz-box-shadow:0 0 20px rgba(0,0,0,0.8);
    box-shadow:0 0 20px rgba(0,0,0,0.8);
    top:10px;
    bottom:10px;
    left:0;
    right:0;
    -moz-border-radius:100px / 10px;
    border-radius:100px / 10px;
}
.sh-h8:after
{
    right:10px;
    left:auto;
    -webkit-transform:skew(8deg) rotate(3deg);
    -moz-transform:skew(8deg) rotate(3deg);
    -ms-transform:skew(8deg) rotate(3deg);
    -o-transform:skew(8deg) rotate(3deg);
    transform:skew(8deg) rotate(3deg);
}