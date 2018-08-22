<template>
    <div class="container crane-vedio">
        <el-row style="margin-top: 20px;">
            <el-form :model="form" size="mini">
                <el-form-item label="项目名称" :label-width="formLabelW">
                    <el-input  auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="产权单位" :label-width="formLabelW">
                    <el-input  auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="备案编号" :label-width="formLabelW">
                    <el-input auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="黑匣子SN" :label-width="formLabelW">
                    <el-input  auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="是否在线" :label-width="formLabelW">
                    <el-select v-model="form.is_online" placeholder="请选择活动区域">
                        <el-option label="有在线设备" value="有在线设备"></el-option>
                        <el-option label="无在线设备" value="无在线设备"></el-option>
                        <el-option label="全部" value="全部"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="是否报警" :label-width="formLabelW">
                    <el-select v-model="form.is_police" placeholder="请选择活动区域">
                        <el-option label="有报警设备" value="有报警设备"></el-option>
                        <el-option label="无报警设备" value="无报警设备"></el-option>
                    </el-select>
                </el-form-item>
                <el-button type="primary" plain size="mini" style="float: left">查询</el-button>
                <el-button size="mini" style="float: left">清空</el-button>
            </el-form>
        </el-row>
        <el-row>
            <el-table
                    :data="tableData"
                    border
                    style="width: 100%"
            >
                <el-table-column type="expand" style="width: 100%;">
                    <template slot-scope="props" style="width: 100%;">
                        <el-form label-position="left" inline class="demo-table-expand">
                            <el-table :data="tableData1" style="width: 100%;">
                                <el-table-column label="SN" align="center" prop="sn" width="100">
                                </el-table-column>
                                <el-table-column label="备案编号" align="center" prop="record_no" width="100">
                                </el-table-column>
                                <el-table-column label="项目编号" align="center" prop="number" width="100">
                                </el-table-column>
                                <el-table-column label="机械类型" align="center" prop="type" width="100">
                                </el-table-column>
                                <el-table-column label="状态" align="center" prop="state" width="100">
                                </el-table-column>
                                <el-table-column label="查看" align="center" prop="look" width="700">
                                    <template slot-scope="scope">
                                        <el-button size="mini" type="success" plain class="cvedio_btn">实时监控</el-button>
                                        <el-button size="mini" type="info" plain class="cvedio_btn">监控回放</el-button>
                                        <el-button size="mini" type="primary" plain class="cvedio_btn">运行数据</el-button>
                                        <el-button size="mini" type="danger" plain class="cvedio_btn">报警信息</el-button>
                                        <el-button size="mini" type="warning" plain class="cvedio_btn">运行时间</el-button>
                                        <el-button size="mini" type="primary" plain class="cvedio_btn">受控状态</el-button>
                                        <el-button size="mini" type="success" plain class="cvedio_btn">违章统计分析</el-button>
                                    </template>
                                </el-table-column>
                            </el-table>
                        </el-form>
                    </template>
                </el-table-column>
                <el-table-column
                        prop="id"
                        align="center"
                        width="60"
                        fixed
                        sortable
                        label="#"
                >
                    <template slot-scope="scope">
                        <span>{{ scope.row.id }}</span>
                    </template>
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="项目名称"
                        width="300"
                        align="center"
                >
                </el-table-column>
                <el-table-column
                        prop="construction_unit"
                        label="施工单位"
                        width="300"
                        align="center"
                >
                </el-table-column>
                <el-table-column
                        prop="tower_crane"
                        label="塔机"
                        width="650"
                        align="center"
                >
                    <el-table-column
                            prop="total"
                            label="总计"
                            width="100"
                            align="center"
                >
                    </el-table-column>
                    <el-table-column
                            prop="on_line"
                            label="在线"
                            width="100"
                            align="center"
                    >
                    </el-table-column>
                    <el-table-column
                            prop="off_line"
                            label="离线"
                            width="100"
                            align="center"
                    >
                    </el-table-column>
                    <el-table-column
                            prop="warning"
                            label="预警"
                            width="100"
                            align="center"
                    >
                    </el-table-column>
                    <el-table-column
                            prop="call_police"
                            label="报警"
                            width="100"
                            align="center"
                    >
                    </el-table-column>
                    <el-table-column
                            prop="look"
                            label="查看"
                            width="150"
                            align="center"
                    >
                        <template slot-scope="scope">
                            <el-button size="mini" type="primary" plain class="cvedio_btn" @click="handleCrane">塔机分布</el-button>
                        </template>
                    </el-table-column>
                </el-table-column>
            </el-table>
        </el-row>
        <el-row style="margin-top: 20px;">
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-sizes="[30, 60, 90, 120]"
                    :page-size="pagesize"
                    :pager-count="11"
                    layout="total, sizes, prev, pager, next, jumper,slot,->"
                    :total="total">
            </el-pagination>
        </el-row>



        <el-dialog :visible.sync="distribution" title="塔机分布">
            <svg height="568" version="1.1" width="798" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative;" viewBox="858.9130281690141 922.7 250.8 270.6" preserveAspectRatio="xMinYMin">
                <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.2</desc>
                <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                <circle cx="1000" cy="1000" r="65" fill="#008000" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0.3; cursor: pointer;" fill-opacity="0.3" stroke-dasharray="1,1" stroke-width="0.4764084507042254"></circle>
                <text x="1000" y="1005" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 4px Arial;" font-size="4px" stroke-width="0.4764084507042254">
                    <tspan dy="1.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">1#  坐标(1000,1000)
                    </tspan>
                </text>
                <circle cx="1000" cy="1000" r="2" fill="none" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);" stroke-width="0.4764084507042254"></circle>
                <rect x="990" y="999" width="75" height="2" r="0" rx="0" ry="0" fill="none" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);" transform="matrix(-0.1354,0.9908,-0.9908,-0.1354,2126.1649,144.5746)" stroke-width="0.4764084507042254"></rect>
                <circle cx="1000" cy="1000" r="1.5" fill="#000000" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);" transform="matrix(-0.1354,0.9908,-0.9908,-0.1354,2126.1649,144.5746)" stroke-width="0.4764084507042254"></circle>
                <circle cx="1098" cy="1116" r="65" fill="#008000" stroke="#000" fill-opacity="0.3" stroke-dasharray="1,1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0.3; cursor: pointer;" stroke-width="0.4764084507042254"></circle>
                <text x="1098" y="1121" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 4px Arial;" font-size="4px" stroke-width="0.4764084507042254">
                    <tspan dy="1.5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">3#  坐标(1098,1116)</tspan>
                </text>
                <circle cx="1098" cy="1116" r="2" fill="none" stroke="#000" stroke-width="0.4764084507042254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                <rect x="1088" y="1115" width="75" height="2" r="0" rx="0" ry="0" fill="none" stroke="#000" transform="matrix(-0.5834,0.8122,-0.8122,-0.5834,2644.9715,875.2943)" stroke-width="0.4764084507042254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>
                <circle cx="1113.09" cy="1116" r="1.5" fill="#000000" stroke="#000" transform="matrix(-0.5834,0.8122,-0.8122,-0.5834,2644.9715,875.2943)" stroke-width="0.4764084507042254" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle></svg>
        </el-dialog>
       <div id="container">
            <!--<svg height="600" version="1.1" width="800" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative;">-->
                <!--<desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.1.2</desc>-->
                <!--<defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>-->
                <!--<image x="0" y="0" width="800" height="600" preserveAspectRatio="none" xlink:href="/static/img/background.jpg" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></image>-->
                <!--<image x="164.74285714285713" y="110" width="19" height="12" preserveAspectRatio="none" xlink:href="/static/img/car.png" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></image>-->
                <!--<image x="164.74285714285713" y="122" width="19" height="250" preserveAspectRatio="none" xlink:href="/static/img/rope.png" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></image>-->
                <!--<image x="164.74285714285713" y="370" width="19" height="19" preserveAspectRatio="none" xlink:href="/static/img/hook.png" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></image>-->
                <!--<image x="658" y="428" width="37" height="34" preserveAspectRatio="none" xlink:href="/static/img/Windspeed.jpg" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);" transform="matrix(1,0,0,1,0,0)"></image>-->
                <!--<text x="120" y="16" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 12px Arial;">-->
                <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">103691</tspan></text>-->
                <!--<text x="340" y="16" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 12px Arial;">-->
                <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">1</tspan></text>-->
                <!--<text x="680" y="16" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 12px Arial;">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2017/07-28 18:40:58</tspan>-->
                <!--</text>-->
                <!--<circle cx="780" cy="16" r="10" fill="#ff0000" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>-->
                <!--<text x="80" y="52" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 12px Arial;">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">56</tspan>-->
                <!--</text>-->
                <!--<text x="190" y="52" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 12px Arial;">-->
                <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10</tspan></text>-->
                <!--<text x="300" y="52" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 12px Arial;">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">33</tspan>-->
                <!--</text>-->
                <!--<text x="380" y="52" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 12px Arial;">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2</tspan>-->
                <!--</text>-->
                <!--<circle cx="600" cy="225" r="150" fill="#808080" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0.3;" fill-opacity="0.3"></circle><circle cx="600" cy="225" r="6" fill="none" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>-->
                <!--<rect x="580" y="222" width="170" height="5" r="0" rx="0" ry="0" fill="none" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);" transform="matrix(-0.0835,-0.9965,0.9965,-0.0835,425.8882,841.6929)"></rect>-->
                <!--<circle cx="627.9642857142857" cy="225" r="4" fill="#000000" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);" transform="matrix(-0.0835,-0.9965,0.9965,-0.0835,425.8882,841.6929)"></circle>-->
                <!--<text x="50" y="480" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: bold 12px Arial;" font-weight="bold">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10.44</tspan>-->
                <!--</text>-->
                <!--<rect x="8" y="564" width="84" height="21" r="0" rx="0" ry="0" fill="#008000" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<rect x="5" y="493" width="16.77857142857143" height="14" r="0" rx="0" ry="0" fill="#808080" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<text x="150" y="480" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: bold 12px Arial;" font-weight="bold">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">未安装</tspan></text>-->
                <!--<rect x="108" y="564" width="84" height="21" r="0" rx="0" ry="0" fill="#008000" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<rect x="105" y="493" width="90" height="14" r="0" rx="0" ry="0" fill="#808080" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<text x="250" y="480" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: bold 12px Arial;" font-weight="bold">-->
                <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">未安装</tspan></text>-->
                <!--<rect x="208" y="564" width="84" height="21" r="0" rx="0" ry="0" fill="#008000" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<rect x="205" y="493" width="88.8025" height="14" r="0" rx="0" ry="0" fill="#808080" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<text x="350" y="480" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: bold 12px Arial;" font-weight="bold">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0.00</tspan>-->
                <!--</text>-->
                <!--<rect x="308" y="564" width="84" height="21" r="0" rx="0" ry="0" fill="#008000" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<rect x="305" y="493" width="0" height="14" r="0" rx="0" ry="0" fill="#808080" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<text x="450" y="480" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: bold 12px Arial;" font-weight="bold">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0.00</tspan>-->
                <!--</text>-->
                <!--<rect x="408" y="564" width="84" height="21" r="0" rx="0" ry="0" fill="#008000" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<rect x="405" y="493" width="0" height="14" r="0" rx="0" ry="0" fill="#808080" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<text x="550" y="480" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: bold 12px Arial;" font-weight="bold">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0.00</tspan>-->
                <!--</text>-->
                <!--<rect x="508" y="564" width="84" height="21" r="0" rx="0" ry="0" fill="#008000" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<rect x="505" y="493" width="0" height="14" r="0" rx="0" ry="0" fill="#808080" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<text x="650" y="480" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: bold 12px Arial;" font-weight="bold">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">未安装</tspan>-->
                <!--</text>-->
                <!--<rect x="608" y="564" width="84" height="21" r="0" rx="0" ry="0" fill="#008000" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<rect x="605" y="493" width="0" height="14" r="0" rx="0" ry="0" fill="#808080" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<text x="750" y="480" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: bold 12px Arial;" font-weight="bold">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">未安装</tspan>-->
                <!--</text>-->
                <!--<rect x="708" y="564" width="84" height="21" r="0" rx="0" ry="0" fill="#008000" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<rect x="705" y="493" width="0" height="14" r="0" rx="0" ry="0" fill="#808080" stroke="#000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></rect>-->
                <!--<text x="600" y="240" text-anchor="middle" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font: 12px Arial;">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">103691  坐标(0,0)</tspan>-->
                <!--</text>-->
                <!--<text x="130" y="150" text-anchor="start" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: start; font: 12px Arial;">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">项目名称: 塔城地区中级人民法院审判法庭</tspan>-->
                <!--</text>-->
                <!--<text x="130" y="185" text-anchor="start" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: start; font: 12px Arial;">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">项目地址: 塔城市巴克图路北侧、园林苗圃西侧</tspan>-->
                <!--</text>-->
                <!--<text x="130" y="220" text-anchor="start" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: start; font: 12px Arial;">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">项目经理: 刘建军</tspan>-->
                <!--</text>-->
                <!--<text x="130" y="255" text-anchor="start" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: start; font: 12px Arial;">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">联系电话: 13999407520</tspan>-->
                <!--</text>-->
                <!--<text x="130" y="290" text-anchor="start" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: start; font: 12px Arial;">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">施工单位: 新疆兵团第四建筑安装工程公司</tspan>-->
                <!--</text>-->
                <!--<text x="130" y="325" text-anchor="start" font="12px &quot;Arial&quot;" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: start; font: 12px Arial;">-->
                    <!--<tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">建设单位: 未填写</tspan>-->
                <!--</text>-->
            <!--</svg>-->
        </div>
    </div>
</template>


<script>
    import {pagesize, perPagesize} from '../../config/common'
    export default{
        data(){
            return{
                form:{
                    is_online: '',
                    is_police: '',
                },
                formLabelW: "120px",
                tableData: [{
                    id: '1',
                    name: '中铁隧道集团科技大厦',
                    construction_unit: '中铁隧道集团四处有限公司',
                    tower_crane: '2',
                    total: '2',
                    on_line: '0',
                    off_line: '0',
                    warning: '1',
                    call_police: '1',
                }],
                tableData1: [
                    {
                    sn: '12987122',
                    record_no: '121212',
                    number: '123232',
                    type: '塔机',
                    state: '在线',
                    look: '',
                }],
                currentPage: 1, //当前页数
                pagesize: pagesize,
                perPagesize: perPagesize,
                total: null,
                distribution: false
            }
        },
        methods:{
            handleSizeChange(val) {
                console.log(`每页 ${val} 条`);
            },
            handleCurrentChange(val) {
                console.log(`当前页: ${val}`);
            },
            handleCrane(){
                this.distribution = true
            }
        }
    }
</script>
<style>
     .crane-vedio .el-form-item{
        width: 20%;
        float: left;
        padding-right: 60px;
    }
    .cvedio_btn{
        margin: 10px 0px;
    }
</style>

