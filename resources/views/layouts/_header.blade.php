<el-header class="header-container" height="auto">
    <div class="header-nav clearfix">
        <h1 class="web-logo"><img src="/static/img/logo3.png" class="logo-img clearfix" alt=""></h1>
        <div class="as-header__actions">
            <ul class="as-menu__top clearfix">
                <li v-for="(header,index) in headers" class="el-menu-item" :key="index" @click="getSideBars(index)" :class="{ is_active: index === activeNavIndex }">
                    <i :class="`icon-menu__top ${header.icon}`"></i> <span v-text="header.label"></span>
                </li>
            </ul>
            <div class="user-navigation">
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
        </div>
    </div>
    <div class="as-tabs__Menu">
        <div class="as-tabs__MenuWrap">
            <el-tabs v-model="tabsValue" type="border-card" closable @tab-remove="removeTab" @tab-click="handleClick" class="as-tabs-box">
                <el-tab-pane
                        v-for="(item, index) in tabs" :key="item.name" :label="item.title" :name="item.name"
                >
                    <span slot="label"><i :class="`${item.icon}`"></i><span v-text="item.title"></span></span>
                </el-tab-pane>
            </el-tabs>
            <div class="as-tabs__tools">
                <div class="as-tabs__toolsWrap">
                    <button type="button" class="as-tabs__icon" @click="pageRefresh">
                        <i class="icon icon-refresh fa fa-refresh"></i>
                    </button>
                    <button type="button" class="as-tabs__icon" @click="pageFullscreen">
                        <i class="icon icon-fullscreen fa fa-arrows-alt"></i>
                    </button>
                    <button type="button" class="as-tabs__icon" @click="pageClose">
                        <i class="icon icon-close fa fa-times"></i>
                        {{--<span><i class="icon-close  glyphicon glyphicon-remove"></i></span>--}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</el-header>