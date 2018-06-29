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
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    <div class="homepage-header">
        <el-row :gutter="10">
            <el-col :xs="8" :sm="12" :md="14" :lg="16" :xl="19"><img src="/static/img/logo2.png" class="logo-img" alt=""></el-col>
            <el-col :xs="8" :sm="6" :md="5" :lg="3" :xl="2" class="Home-p">
                <i class="fa fa-home"></i><span>系统首页</span>
            </el-col>
            {{--<el-col :span="2" class="Modify"><i class="fa fa-gears"></i><span>修改密码</span></el-col>--}}
            {{--<el-col :span="2" class="Exit"><i class="fa fa-sign-out"></i><span>安全退出</span></el-col>--}}
            <el-col :xs="8" :sm="6" :md="5" :lg="3" :xl="2">
                <el-menu class="el-menu-demo dropdown" mode="horizontal"
                        background-color="#6f7994"
                        text-color="#fff"
                        active-text-color="#ffd04b">
                    <el-submenu index="1" style="background: #fff;">
                        <template slot="title" class="clearfix"><img src="/static/img/user.png" alt="" class="tit-user clearfix"><span class="tit-username">linlin@</span></template>
                        <el-menu-item index="2-1"><i class="fa fa-gears"></i><span class="changepwd">修改密码</span></el-menu-item>
                        <el-menu-item index="2-2"><i class="fa fa-sign-out"></i><span class="signput">安全退出</span></el-menu-item>
                    </el-submenu>
                </el-menu>
            </el-col>
        </el-row>
    </div>
    <div class="nav">
        <div class="homepage-title">
                {{--<el-button type="info" plain v-for="item in contacts" class="tit-tab"><i :class="`fa fa-${item.icon}`"></i>${item.item}</el-button>--}}
                <el-row>
                    <el-col :span="24">
                        <span class="fa fa-bars take"></span>
                        <el-menu default-active="2" class="el-menu-vertical-demo" style="background: #6f7994;color: #fff;" v-for="item in nav">
                            <el-submenu index="1" style="color: #fff;">
                                <template slot="title">
                                    <i :class="`fa fa-${item.icon}`" style="color: #fff;"></i>
                                    <span class="tit-tab" v-text="item.label"></span>
                                </template>
                                <div v-for="child in item.child">
                                    <el-menu-item-group v-if="typeof child.child === 'undefined'">
                                        <el-menu-item index="1-1" v-text="child.label"></el-menu-item>
                                    </el-menu-item-group>

                                    <el-submenu index="1-4" v-if="typeof child.child !== 'undefined'">
                                        <template slot="title" v-text="child.label"></template>
                                        <el-menu-item index="1-4-1" v-for="c in child.child" v-text="c.label"></el-menu-item>
                                    </el-submenu>
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
