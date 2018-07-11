<template>
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
                   11ss
                </el-menu>
            </div>
        </div>
    </el-header>
</template>

<script>
    import Entry from './Entry'
    export default {
        name: 'Header',
        components: {
            Entry
        },

    }
</script>

<style scoped>
    .title { display: none;}
    .navbar-default .navbar-nav > .active > a { background: rgba(0,0,0,.03);}
</style>