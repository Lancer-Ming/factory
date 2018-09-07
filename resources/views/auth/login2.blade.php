<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/app.css">
    <title>login</title>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        html,body {
            margin:0;
            overflow:hidden;
            width:100%;
            height:100%;
            background:black;
            background:linear-gradient(to bottom,#000000 0%,#5788fe 100%);
        }
        .filter {
            width:100%;
            height:100%;
            position:absolute;
            top:0;
            left:0;
            background:#fe5757;
            animation:colorChange 30s ease-in-out infinite;
            animation-fill-mode:both;
            mix-blend-mode:overlay;
        }
        @keyframes colorChange {
            0%,100% {
                opacity:0;
            }
            50% {
                opacity:.9;
            }
        }.landscape {
             position:absolute;
             bottom:0px;
             left:0;
             width:100%;
             height:100%;
             /*background-image:url(https://openclipart.org/image/2400px/svg_to_png/250847/Trees-Landscape-Silhouette.png);
             */
             background-image:url('img/xkbg.png');
             background-size:1000px 250px;
             background-repeat:repeat-x;
             background-position:center bottom;
         }
        .wrapper{
            position: relative;
        }
    </style>
</head>
<body>
<canvas id="canvas"></canvas>
<div class="wrapper">
    <div class="row container">
        <div class="col-sm-11 col-xs-6"><img src="/static/img/logo2.png"></div>
        <div class="col-sm-1 col-xs-6"><img src="/static/img/logo1.png" alt="" class="img-r"></div>
    </div>
    <div class="index-nav">

        @include('layouts._message')

        <div class="row nav-index">
            <div class="col-lg-8 col-md-7 col-sm-5 col-xs-3">&nbsp;</div>
            <div class="col-lg-3 col-md-4 col-sm-5 col-xs-7 login-index">
                <div class="login-nav">
                    <span>WELCOME TO LOG IN</span>
                    <div class="login-title clearfix">
                        <form action="/login" method="post">
                            {{ csrf_field() }}
                            <div class="login-box">
                                <div class="box-tab">
                                    <div class="user">
                                        <i class="fa fa-user"></i>
                                        <input type="text" placeholder="请输入用户名" name="username" value="">
                                    </div>
                                    <div class="password">
                                        <i class="fa fa-key"></i>
                                        <input type="password" placeholder="请输入密码" name="password" value="">
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" value="1">记住密码
                                    </label>
                                    <label class="forget">忘记密码？</label>
                                </div>
                                <button class="login-btn" type="submit">登录</button>
                                <span class="fot"><i class="glyphicon glyphicon-copyright-mark"></i>广州安拾科技有限公司</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="login-footer">
            <span>
                <i class="fa fa-heart" style="color: #c56666;"></i>未经安拾科技有限公司同意，不得转载本网站之所有信息
            </span>
    </div>
</div>
<script>
    document.addEventListener('click', function(event) {
        var target = event.target;
        var closeDom = document.querySelector('button.close span');
        if (target == closeDom) {
            document.querySelector('.flash-message').innerHTML = '';
        }
    })
</script>
<script>
    function Star(id, x, y){
        this.id = id;
        this.x = x;
        this.y = y;
        this.r = Math.floor(Math.random()*2)+1;
        var alpha = (Math.floor(Math.random()*10)+1)/10/2;
        this.color = "rgba(255,255,255,"+alpha+")";
    }

    Star.prototype.draw = function() {
        ctx.fillStyle = this.color;
        ctx.shadowBlur = this.r * 2;
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.r, 0, 2 * Math.PI, false);
        ctx.closePath();
        ctx.fill();
    }

    Star.prototype.move = function() {
        this.y -= .15;
        if (this.y <= -10) this.y = HEIGHT + 10;
        this.draw();
    }

    Star.prototype.die = function() {
        stars[this.id] = null;
        delete stars[this.id];
    }


    function Dot(id, x, y, r) {
        this.id = id;
        this.x = x;
        this.y = y;
        this.r = Math.floor(Math.random()*5)+1;
        this.maxLinks = 2;
        this.speed = .5;
        this.a = .5;
        this.aReduction = .005;
        this.color = "rgba(255,255,255,"+this.a+")";
        this.linkColor = "rgba(255,255,255,"+this.a/4+")";

        this.dir = Math.floor(Math.random()*140)+200;
    }

    Dot.prototype.draw = function() {
        ctx.fillStyle = this.color;
        ctx.shadowBlur = this.r * 2;
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.r, 0, 2 * Math.PI, false);
        ctx.closePath();
        ctx.fill();
    }

    Dot.prototype.link = function() {
        if (this.id == 0) return;
        var previousDot1 = getPreviousDot(this.id, 1);
        var previousDot2 = getPreviousDot(this.id, 2);
        var previousDot3 = getPreviousDot(this.id, 3);
        if (!previousDot1) return;
        ctx.strokeStyle = this.linkColor;
        ctx.moveTo(previousDot1.x, previousDot1.y);
        ctx.beginPath();
        ctx.lineTo(this.x, this.y);
        if (previousDot2 != false) ctx.lineTo(previousDot2.x, previousDot2.y);
        if (previousDot3 != false) ctx.lineTo(previousDot3.x, previousDot3.y);
        ctx.stroke();
        ctx.closePath();
    }

    function getPreviousDot(id, stepback) {
        if (id == 0 || id - stepback < 0) return false;
        if (typeof dots[id - stepback] != "undefined") return dots[id - stepback];
        else return false;//getPreviousDot(id - stepback);
    }

    Dot.prototype.move = function() {
        this.a -= this.aReduction;
        if (this.a <= 0) {
            this.die();
            return
        }
        this.color = "rgba(255,255,255,"+this.a+")";
        this.linkColor = "rgba(255,255,255,"+this.a/4+")";
        this.x = this.x + Math.cos(degToRad(this.dir))*this.speed,
            this.y = this.y + Math.sin(degToRad(this.dir))*this.speed;

        this.draw();
        this.link();
    }

    Dot.prototype.die = function() {
        dots[this.id] = null;
        delete dots[this.id];
    }


    var canvas  = document.getElementById('canvas'),
        ctx = canvas.getContext('2d'),
        WIDTH,
        HEIGHT,
        mouseMoving = false,
        mouseMoveChecker,
        mouseX,
        mouseY,
        stars = [],
        initStarsPopulation = 80,
        dots = [],
        dotsMinDist = 2,
        maxDistFromCursor = 50;

    setCanvasSize();
    init();

    function setCanvasSize() {
        WIDTH = document.documentElement.clientWidth,
            HEIGHT = document.documentElement.clientHeight;

        canvas.setAttribute("width", WIDTH);
        canvas.setAttribute("height", HEIGHT);
    }

    function init() {
        ctx.strokeStyle = "white";
        ctx.shadowColor = "white";
        for (var i = 0; i < initStarsPopulation; i++) {
            stars[i] = new Star(i, Math.floor(Math.random()*WIDTH), Math.floor(Math.random()*HEIGHT));
            //stars[i].draw();
        }
        ctx.shadowBlur = 0;
        animate();
    }

    function animate() {
        ctx.clearRect(0, 0, WIDTH, HEIGHT);

        for (var i in stars) {
            stars[i].move();
        }
        for (var i in dots) {
            dots[i].move();
        }
        drawIfMouseMoving();
        requestAnimationFrame(animate);
    }

    window.onmousemove = function(e){
        mouseMoving = true;
        mouseX = e.clientX;
        mouseY = e.clientY;
        clearInterval(mouseMoveChecker);
        mouseMoveChecker = setTimeout(function() {
            mouseMoving = false;
        }, 100);
    }


    function drawIfMouseMoving(){
        if (!mouseMoving) return;

        if (dots.length == 0) {
            dots[0] = new Dot(0, mouseX, mouseY);
            dots[0].draw();
            return;
        }

        var previousDot = getPreviousDot(dots.length, 1);
        var prevX = previousDot.x;
        var prevY = previousDot.y;

        var diffX = Math.abs(prevX - mouseX);
        var diffY = Math.abs(prevY - mouseY);

        if (diffX < dotsMinDist || diffY < dotsMinDist) return;

        var xVariation = Math.random() > .5 ? -1 : 1;
        xVariation = xVariation*Math.floor(Math.random()*maxDistFromCursor)+1;
        var yVariation = Math.random() > .5 ? -1 : 1;
        yVariation = yVariation*Math.floor(Math.random()*maxDistFromCursor)+1;
        dots[dots.length] = new Dot(dots.length, mouseX+xVariation, mouseY+yVariation);
        dots[dots.length-1].draw();
        dots[dots.length-1].link();
    }
    //setInterval(drawIfMouseMoving, 17);

    function degToRad(deg) {
        return deg * (Math.PI / 180);
    }
</script>
</body>
</html>


