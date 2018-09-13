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