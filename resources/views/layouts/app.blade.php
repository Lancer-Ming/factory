<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    {{--<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">--}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    <div class="homepage-header clearfix">
        <img src="/static/img/logo2.png" class="logo-img clearfix" alt="">
        <ul class="sidebar-f">
            <li v-for="(header,index) in headers" :key="index" v-text="header.label" @click="getSideBars(header.id)"></li>
        </ul>
        <div class="sidebar-r">
            <div class="home">
                <i class="fa fa-home"></i><span>系统首页</span>
            </div>
            <div class="user-h">
                <li><img src="/static/img/user.png" alt="" class="tit-user clearfix">linlin@
                    <ul>
                        <li><i class="fa fa-gears"></i><span class="changepwd">修改密码</span></li>
                        <li><i class="fa fa-sign-out"></i><span class="signput">安全退出</span></li>
                    </ul>
                </li>
            </div>
        </div>
    </div>
    <div class="nav">
        <div class="homepage-title">
            <el-row :collapse="isCollapse">
                    <el-col :span="24">
                        <span class="fa fa-bars take"></span>
                        <el-menu default-active="2" class="el-menu-vertical-demo" style="background: #333;color: #fff;" v-for="(item,index) in sidebars" :key="index">
                            <el-submenu index="index" style="color: #fff;">
                                <template slot="title">
                                    <i :class="`fa fa-${item.icon}`" style="color: #fff;"></i>
                                    <span class="tit-tab" v-text="item.label"></span>
                                </template>
                                <div v-for="(child,child_index) in item.children" :key="child_index">
                                    <el-menu-item index="child_index" v-text="child.label"></el-menu-item>
                                </div>
                            </el-submenu>
                        </el-menu>
                    </el-col>
            </el-row>
        </div>
    </div>
</div>
</body>

</html>
