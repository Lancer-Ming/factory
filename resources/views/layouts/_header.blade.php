<el-header class="header-container" height="48px">
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