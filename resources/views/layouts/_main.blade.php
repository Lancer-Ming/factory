<el-container class="main-container">
    <el-main class="main-wrapper">
        <el-breadcrumb separator-class="el-icon-arrow-right">
            <el-breadcrumb-item :to="{ path: '/' }">安拾科技管理平台</el-breadcrumb-item>
        </el-breadcrumb>
        {{--<div class="explanation mb10" id="explanation">--}}
        {{--页面操作提示模块--}}
            {{--<div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>--}}
            {{--<ul>--}}
                {{--<li></li>--}}
                {{--<li></li>--}}
                {{--<li></li>--}}
            {{--</ul>--}}
        {{--</div>--}}

        <div class="view-container">
            <router-view/>
        </div>
    </el-main>
</el-container>