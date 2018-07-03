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
            <li v-for="(header,index) in headers" :key="index" v-text="header.label" @click="getSideBars(index)"></li>
        </ul>
        <div class="sidebar-r">
            <div class="home">
                <a href=""><i class="fa fa-home"></i><span>系统首页</span></a>
            </div>
            <div class="user-h">
                <el-menu class="el-menu-demo" mode="horizontal"  background-color="#545c64" text-color="#fff" active-text-color="#ffd04b">
                    <el-submenu index="2">
                        <template slot="title"><img src="/static/img/user.png" alt="" class="tit-user clearfix">linlin@</template>
                            <el-menu-item index="2-1"><i class="fa fa-gears" style="color: #fff;display: inline-block;margin: 0 20px 0px 10px;"></i><span class="changepwd">修改密码</span></el-menu-item>
                            <el-menu-item index="2-2"><i class="fa fa-sign-out" style="color: #fff;display: inline-block;margin: 0 20px 0px 10px;"></i><span class="signput">安全退出</span></el-menu-item>
                    </el-submenu>
                </el-menu>
            </div>
        </div>
    </div>
    <div class="nav">
        <div class="homepage-title" v-if="sidebars.length > 0">
            <el-row>
                    <el-col :span="24">
                        <span class="fa fa-bars take" @click="switchBar"></span>
                        <el-menu class="el-menu-vertical-demo" style="background: #333;color: #fff;" v-for="(item,index) in sidebars" :key="index" :collapse-transition="isTransition" :collapse="isCollapse">
                            <el-submenu :index="`${firstMenuIndex.toString()}-${index.toString()}`" style="color: #fff;" :data-id="`${firstMenuIndex.toString()}-${index.toString()}`">
                                <template slot="title">
                                    {{--<i :class="`fa fa-${item.icon}`" style="color: #fff;"></i>--}}
                                    <span class="tit-tab" v-text="item.label"></span>
                                </template>
                                <div v-for="(child,child_index) in item.children" :key="child_index">
                                    <el-menu-item :index="`${firstMenuIndex.toString()}-${index.toString()}-${child_index.toString()}`" v-text="child.label" style="padding: 0px 60px;" :data-id="`${firstMenuIndex.toString()}-${index.toString()}-${child_index.toString()}`"></el-menu-item>
                                </div>
                            </el-submenu>
                        </el-menu>
                    </el-col>

            </el-row>
        </div>
        <div class="homepage-tab">
            <el-tabs type="card" :closable="true" @tab-remove="removeTab">
                <el-tab-pane
                        v-for="(item, index) in editableTabs2"
                        :key="item.name"
                        :label="item.title"
                        :name="item.name"
                >
                    ${item.content}
                </el-tab-pane>
            </el-tabs>
            </el-tabs>
        </div>
    </div>
</div>
</body>

</html>
