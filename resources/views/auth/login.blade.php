<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--<link rel="stylesheet" href="/css/app.css">--}}
    <title>login</title>
    {{--<link href="{{asset('/vendor/bootstrap/bootstrap.min.css')}}" rel="stylesheet">--}}
    {{--<link href="{{asset('/vendor/awesome/font-awesome.min.css')}}" rel="stylesheet">--}}
    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">--}}
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('/css/login.css')}}" rel="stylesheet">
</head>
<body>
<div class="wrapper login-page">
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
                        <span>WELCOME TO LOGIN</span>
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
                <i class="fa fa-heart" style="color: #c56666;"></i>未经广州安拾科技有限公司同意，不得转载本网站之所有信息
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
</body>
</html>


