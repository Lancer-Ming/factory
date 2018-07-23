<el-container>
    {{--<el-breadcrumb separator-class="el-icon-arrow-right">--}}
        {{--<el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>--}}
        {{--<el-breadcrumb-item>活动管理</el-breadcrumb-item>--}}
        {{--<el-breadcrumb-item>活动列表</el-breadcrumb-item>--}}
        {{--<el-breadcrumb-item>活动详情</el-breadcrumb-item>--}}
    {{--</el-breadcrumb>--}}
    {{--<el-header class="main-header" height="40px">--}}
        {{--<el-tabs v-model="tabsValue" type="card" closable @tab-remove="removeTab" @tab-click="handleClick">--}}
            {{--<el-tab-pane--}}
                    {{--v-for="(item, index) in tabs"--}}
                    {{--:key="item.name"--}}
                    {{--:label="item.title"--}}
                    {{--:name="item.name"--}}
            {{-->--}}
                {{--${item.content}--}}
            {{--</el-tab-pane>--}}
        {{--</el-tabs>--}}
    {{--</el-header>--}}
    <el-main class="main-container">
        <router-view/>
    </el-main>
    <el-footer>
    </el-footer>
</el-container>