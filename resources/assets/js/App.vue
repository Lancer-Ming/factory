<template>
    <div id="layout-app">
        <el-container class="page-container">

            <el-header class="header-container" height="auto">
                <div class="header-nav clearfix">
                    <h1 class="web-logo"><img :src="logoImg" class="logo-img clearfix" alt=""></h1>
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
                                            <img src="/static/img/user.png" alt="" class="tit-user clearfix">{{ userName }}
                                        </template>
                                        <el-menu-item index="2-1">
                                            <i class="fa fa-gears" style="color: #fff;display: inline-block;margin: 0 20px 0px 10px;"></i><span class="changepwd">修改密码</span>
                                        </el-menu-item>
                                        <el-menu-item index="2-2" @click="logout">
                                            <i class="fa fa-sign-out" style="color: #fff;display: inline-block;margin: 0 20px 0px 10px;"></i>
                                            <form action="/logout" class="logout" style="display: inline-block" method="post">
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
                        <el-tabs v-model="activeTabValue" type="border-card" closable @tab-remove="removeTab" @tab-click="handleClick" class="as-tabs-box">
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
                                    <!--<span><i class="icon-close  glyphicon glyphicon-remove"></i></span>-->
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </el-header>

            <el-container class="section-container">

                <el-aside width="auto" v-if="sidebars.length > 0" class="aside-wrapper">
                    <el-row>
                        <el-col :span="24">
                            <span class="el-sideclose fa fa-bars take" @click="switchBar"></span>
                            <el-menu class="el-menu-vertical-sidebar" style="color: #fff;"
                                    :collapse-transition="false"
                                    :collapse="isCollapse"
                                    :unique-opened="true"
                                    :default-openeds="currentOpenMenuName"
                                    @select="addTab"
                                    @open="openSubMenu"
                                    router>
                                <el-submenu v-for="(item,index) in sidebars" :key="index" v-if="item.children.length > 0"
                                        :index="`/${item.name.split('.').join('/')}`" style="color: #fff;"
                                        :data-id="`/${item.name.split('.').join('/')}`"
                                        :class="{'is-highlight': item.name === activeSideBar}"
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
                                                :class="{'is-highlight': child.name === activeSideBar}"
                                        >
                                        </el-menu-item>
                                    </div>
                                </el-submenu>
                                <el-menu-item v-for="(item,index) in sidebars" :key="index" v-if="item.children.length === 0"
                                        :index="`/${item.name.split('.').join('/')}`"
                                        :class="{'is-highlight': item.name === activeSideBar}"
                                        :data-id="item.name">
                                    <i :class="`small-logo fa fa-${item.icon}`" style="color: #fff;"></i>
                                    <span slot="title" class="tit-tab" v-text="item.label"></span>
                                </el-menu-item>
                            </el-menu>
                        </el-col>

                    </el-row>
                </el-aside>

                <el-container class="main-container">
                    <el-main class="main-wrapper">
                        <breadcrumb></breadcrumb>
                        <div class="view-container" :class="this.$route.path.split('/').join('_').substr(1)">
                            <router-view/>
                        </div>
                    </el-main>
                </el-container>
            </el-container>
            <el-footer style="height: auto">
                2018 © 广东德实控股有限公司<p style="color:#666;">安拾科技技术支持</p>
            </el-footer>
        </el-container>
    </div>
</template>
<script>
    import {Local} from './utils/common'
    import {implode} from "./utils/common.js"
    import {logoUrl} from "./config/common.js"
    import router from './router'
    import Breadcrumb from './components/Breadcrumb'
    import { mapMutations, mapState } from 'vuex'
    export default{
        name: 'app',
        router,
        components: {Breadcrumb},
        data() {
            return {
                headers: [],    // 导航头
                sidebars: [],   // 侧边栏
                userName: '',
                isCollapse: false,      // 是否折叠
                isInit: false,   // 是否刷新初始化
                currentOpenMenuName: [],
                logoImg: '',
                activeTabValue: ''  // 标签当前active 值
            }

        },

        created() {
            this.activeTabValue = this.activeTabs   // 用activeTabValue 来暂存activeTab值
            this.switchActivedUrl()
            this.initLogo()
            this.axios.get("/permission").then(res => {
                this.headers = res.data.data;
                if (this.activeSideBar) {
                    this.setActiveNavIndex(this.recordTabsWithHeader[this.activeSideBar])
                }

                this.getSideBars(this.activeNavIndex)

            })

            this.axios.get("/userinfo").then(res => {
                this.userName = res.data.data.username
            })

            this.isInit = true
        },
        methods: {

            getSideBars(index) {
                //当为首页时
                if (index == 0) {
                    this.$router.push({path: '/'})
                    this.homePageAddTab('/', '智慧工地首页')
                    this.setActiveSideBar('')
                } else {
                    this.sidebars = this.headers[index].children
                    this.isCollapse = false
                }

                //console.log(this.sidebars)
                this.setActiveNavIndex(index)
            },
            switchBar() {
                this.isCollapse = !this.isCollapse
            },
            homePageAddTab(path, title) {
                let name = 'index'
                let isRepeat = false
                let tabs = this.tabs
                if (tabs) {
                     tabs.forEach((item, index) => {
                        if (item.name === name) {
                            isRepeat = true
                        }
                    })
                } else {
                    isRepeat = true
                }

                // 如果是tabs里没有
                if (!isRepeat) {
                    tabs.push({
                        title,
                        name,
                        path: path
                    })

                    this.setTabs(tabs)
                }

                this.setActiveTabs(name)


            },
            addTab(routerName) {
                //console.log(routerName)
                let newTabName = routerName.split('/').join('.').substr(1);
                let path = routerName
                let isRepeat = false
                this.tabs.forEach((item, index) => {
                    if (item.name === newTabName) {
                        isRepeat = true
                    }
                })
                if (!isRepeat) {
                    let title = ''
                    this.sidebars.forEach(item => {
                        if (item.children.length > 0) {
                            item.children.forEach(val => {
                                val.name === newTabName ? title = item.label : ''
                            })
                        }
                        if (item.name === newTabName) {
                            title = item.label
                        }
                    })

                    this.tabs.push({
                        title,
                        name: newTabName,
                        path: path
                    })

                    this.setTabs(this.tabs)
                }
                // 设置为高亮
                this.setActiveTabs(newTabName)

                this.setActiveSideBar(newTabName)
                // 对tabs的name和header的index进行关联
                this.recordTabsWithHeader[newTabName] = this.activeNavIndex
                this.setRecordTabsWithHeader(this.recordTabsWithHeader)

            },
            removeTab(targetName) {
                let tabs = this.tabs;
                let activeName = this.activeTabs;
                if (activeName === targetName) {
                    tabs.forEach((tab, index) => {
                        if (tab.name === targetName) {
                            let nextTab = tabs[index + 1] || tabs[index - 1];
                            if (nextTab) {
                                activeName = nextTab.name;
                            }
                        }
                    });
                }

                this.setActiveTabs(activeName)
                tabs = tabs.filter(tab => tab.name !== targetName);
                // 给localStorage里更改tabs
                this.setTabs(tabs)
                // 如果tabs全部关闭了
                if (this.tabs.length === 0) {
                    // 清空localStorage
                    new Local().clear()
                    // 清空一写data
                    this.setActiveNavIndex(null),
                        this.setRecordTabsWithHeader({})
                    this.setActiveSideBar('')
                    this.setActiveTabs('')
                    // 跳转主页
                    this.$router.push({path: '/'})
                }
            },
            handleClick: function (tab, event) {
                console.log(tab.name)
                this.setActiveTabs(tab.name)
            },
            logout() {
                this.axios({
                    url: 'logout',
                    method: 'POST',
                }).then(res => {
                    this.setClearAll()
                    location.href = '/login'
                })
            },
            openSubMenu(index) {
                this.currentOpenMenuName[0] = index
                new Local().set('currentOpenMenuName', this.currentOpenMenuName)
            },
            implode(arr, attr) {
                return implode(arr, attr);
            },
            pageRefresh() {
                location.reload();
            },
            pageFullscreen() {
                $(".header-nav").toggle();
                $(".aside-wrapper").toggle();
            },
            pageClose() {
                if (confirm("确认要删除？")) {
                    //window.event.returnValue = false;
                    // 清空localStorage
                    new Local().clear();
                    location.reload();
                }
                return false;
            },
            switchActivedUrl() {
                if (this.activeSideBar) {
                    let activeSideBar = '/' + this.activeSideBar.split('.').join('/')
                    router.push({path: activeSideBar})
                }
            },
            initLogo() {
                let href = location.href
                logoUrl.forEach(item => {
                    if (href.indexOf(item.url) > -1) {
                        this.logoImg = item.image
                    }
                })
            },
            ...mapMutations({
                setActiveTabs: 'setActiveTabs',
                setActiveSideBar: 'setActiveSideBar',
                setRecordTabsWithHeader: 'setRecordTabsWithHeader',
                setTabs: 'setTabs',
                setActiveNavIndex: 'setActiveNavIndex',
                setClearAll: 'setClearAll'
            }) 
        },
        computed: {
            ...mapState({
                tabs: 'tabs',               // 标签数组
                activeTabs: 'activeTabs',       // 标签值
                activeSideBar: 'activeSideBar',     // active 侧边栏
                recordTabsWithHeader: 'recordTabsWithHeader',  // 表示记录标签和头的关系
                activeNavIndex: 'activeNavIndex',   // active 导航索引
            })
        },
        watch: {
            activeTabs(val) {
                const filter = this.tabs.filter(item => {
                    return item.name === val
                })[0]

                const path = filter.path
                const query = filter.query

                // 将currentActiveTab 存到LocalStorage里
                this.setActiveTabs(val)
                // 将其暂存给 activeTabValue 为了tab的v-model 达到高亮效果
                this.activeTabValue = val

                // 如果点击的不是侧边栏
                if (filter.is_sub) {
                    this.$router.push({path, query})
                    this.isInit = false
                    return
                }
    
                this.setActiveSideBar(val)

                // 如果是首页
                if(val === 'index') {
                    this.$router.push({path: path})
                    this.getSideBars(0)
                    return
                }

                if (!this.isInit) {     // 如果是刷新了页面，这个就不用再次获取了。
                    this.isInit = false
                    this.setActiveSideBar(val)
                    this.setActiveNavIndex(this.recordTabsWithHeader[val])
                    this.getSideBars(this.activeNavIndex)
                    // 并且路由跳转
                    this.$router.push({path: path})
                } else {
                    this.isInit = false
                }
            },
            activeTabValue(val) {
                this.setActiveTabs(val)
            }
        },
    }
</script>