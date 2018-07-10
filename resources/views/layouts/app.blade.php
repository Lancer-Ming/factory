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
    <el-container style="height: 100%;">
        <el-header class="index-header">
            <img src="/static/img/logo2.png" class="logo-img clearfix" alt="">
            <ul class="sidebar-f">
                <li :class="{ active: index === activeNavIndex }" :data-id="implode(header.children, 'name')" v-for="(header,index) in headers" :key="index" v-text="header.label" @click="getSideBars(index)"></li>
            </ul>
            <div class="sidebar-r">
                <div class="home">
                    <a href=""><i class="fa fa-home"></i><span>系统首页</span></a>
                </div>
                <div class="user-h">
                    <el-menu class="el-menu-demo" mode="horizontal" background-color="#545c64" text-color="#fff" active-text-color="#ffd04b">
                        <el-submenu index="2">
                            <template slot="title">
                                <img src="/static/img/user.png" alt="" class="tit-user clearfix">{{ Auth::user()->username }}
                            </template>
                            <el-menu-item index="2-1">
                                <i class="fa fa-gears" style="color: #fff;display: inline-block;margin: 0 20px 0px 10px;"></i><span class="changepwd">修改密码</span>
                            </el-menu-item>
                            <el-menu-item index="2-2" @click="logout">
                                <i class="fa fa-sign-out" style="color: #fff;display: inline-block;margin: 0 20px 0px 10px;"></i>
                                <form action="/logout" class="logout" style="display: inline-block" method="post">
                                    {{ csrf_field() }}
                                    <span class="signput">安全退出</span>
                                </form>
                            </el-menu-item>
                        </el-submenu>
                    </el-menu>
                </div>
            </div>
        </el-header>
        <el-container>
            <el-aside width="auto" v-if="sidebars.length > 0" class="index-left">
                <el-row>
                    <el-col :span="24">
                        <span class="fa fa-bars take" @click="switchBar"></span>
                        <el-menu class="el-menu-vertical-demo" style="color: #fff;"
                                :collapse-transition="false"
                                :collapse="isCollapse"
                                default-active='false'
                                :unique-opened="true"
                                :default-openeds="['/statistics/unit']"
                                router
                        >
                            <el-submenu v-for="(item,index) in sidebars" :key="index" v-if="item.children.length > 0"
                                    :index="`/${item.name.split('.').join('/')}`" style="color: #fff;"
                                    :data-id="`/${item.name.split('.').join('/')}`"
                                    :class="{'is-highlight': item.name === tabsValue}"
                            >
                                <template slot="title">
                                    <i :class="`small-logo fa fa-${item.icon}`"></i>
                                    <span slot="title" class="tit-tab" v-text="item.label"></span>
                                </template>
                                <div v-for="(child,child_index) in item.children" :key="child_index">
                                    <el-menu-item style="color: #fff;"
                                            :data-id="`/${child.name.split('.').join('/')}`"
                                            :index="`/${child.name.split('.').join('/')}`"
                                            v-text="child.label"
                                            :class="{'is-highlight': child.name === tabsValue}"
                                            @click="addTab(child.label, child.name)">
                                    </el-menu-item>
                                </div>
                            </el-submenu>
                            <el-menu-item v-for="(item,index) in sidebars" :key="index" v-if="item.children.length === 0"
                                    :index="`/${item.name.split('.').join('/')}`"
                                    :class="{'is-highlight': item.name === tabsValue}"
                                    :data-id="item.name">
                                <i :class="`small-logo fa fa-${item.icon}`" style="color: #fff;"></i>
                                <span slot="title" class="tit-tab" v-text="item.label" @click="addTab(item.label, item.name)"></span>
                            </el-menu-item>
                        </el-menu>
                    </el-col>

                </el-row>
            </el-aside>
            <el-container>
                <el-main class="index-main">
                    <el-tabs v-model="tabsValue" type="card" closable @tab-remove="removeTab" @tab-click="handleClick">
                    <el-tab-pane
                            v-for="(item, index) in tabs"
                            :key="item.name"
                            :label="item.title"
                            :name="item.name"
                    >
                        ${item.content}
                    </el-tab-pane>
                    </el-tabs>

                    <router-view/>
                </el-main>
                <el-footer></el-footer>
            </el-container>


        </el-container>
    </el-container>
</div>
</body>
</html>
