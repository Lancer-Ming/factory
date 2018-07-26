<template>
    <div class="container project" style="height: 100%;">
        <el-row style="border-bottom: 1px solid #eee;padding-bottom: 10px;">
            <el-button round class="pro-btn" @click="handleAdd"><i class="el-icon-circle-plus-outline pro-i"></i>新增项目</el-button>
            <el-button round class="pro-btn" @click=""><i class="el-icon-remove-outline pro-i"></i>移除</el-button>
            <el-button round class="pro-btn" @click=""><i class="el-icon-circle-plus-outline pro-i"></i>添加参建单位</el-button>
            <el-button round class="pro-btn" @click=""><i class="el-icon-refresh pro-i"></i>同步数据</el-button>
        </el-row>
        <split-pane v-on:resize="resize" split="vertical" :default-percent='20' :min-percent='10' :max-percent='30' class="projectBox">
            <template slot="paneL">
                    <div class="pro-box clearfix">
                        <div class="pro-box-l clearfix">
                            <el-row class="pro-l-tit clearfix">
                                <el-col :span="20" style="font-weight: bold;">项目/单位名称</el-col>
                                <i class="el-icon-d-arrow-left tool"></i>
                            </el-row>
                            <el-row class="pro-l-query">
                                <el-col :span="12"><el-input class="query" size="mini"></el-input></el-col>
                                <el-col :span="3">&nbsp;</el-col>
                                <el-col :span="9" class="query-text"><i class="el-icon-search"></i>查询</el-col>
                            </el-row>
                            <el-row>
                                <el-tree :data="data" :props="defaultProps" :highlight-current="true" @node-click="handleNodeClick"></el-tree>
                            </el-row>
                        </div>
                    </div>
            </template>
            <template slot="paneR">
                <div class="right-container">
                    <div class="pro-box">
                        <div class="pro-box-r clearfix">
                            <el-tabs type="border-card">
                                <el-tab-pane label="用户">
                                    <el-row>
                                        姓名：<el-input size="mini" style="width: 20%;margin-right: 30px;"></el-input>
                                        工号：<el-input size="mini" style="width: 20%;"></el-input>
                                        <el-button type="warning" plain class="pro-search" size="mini" icon="el-icon-search">搜索</el-button>
                                    </el-row>
                                </el-tab-pane>
                                <el-tab-pane label="单位信息" disabled>单位信息</el-tab-pane>
                                <el-tab-pane label="项目信息">
                                    <el-button type="warning" plain icon="el-icon-edit" style="margin-bottom: 20px;" @click="handleEdit">保存编辑</el-button>
                                    <el-form :model="form">
                                        <el-form-item label="项目名" :label-width="formLabelWidth">
                                            <el-input v-model="form.id" auto-complete="off"></el-input>
                                        </el-form-item>
                                        <el-form-item label="项目类型" :label-width="formLabelWidth">
                                            <el-select v-model="form.item_category_id" placeholder="请选择项目类型">
                                                <el-option v-for="(item,index) in itemcategory" :key="index" :label="item.name" :value="item.name"></el-option>
                                            </el-select>
                                        </el-form-item>
                                        <el-form-item label="资金来源" :label-width="formLabelWidth">
                                            <el-select v-model="form.invest_id" placeholder="请选择资金来源">
                                                <el-option v-for="(item,index) in invest" :key="index" :label="item.name" :value="item.name"></el-option>
                                            </el-select>
                                        </el-form-item>
                                        <el-form-item label="建设方式" :label-width="formLabelWidth">
                                            <el-select v-model="form.build_type_id" placeholder="请选择建设方式">
                                                <el-option v-for="(item,index) in buildType" :key="index" :label="item.name" :value="item.name"></el-option>
                                            </el-select>
                                        </el-form-item>
                                        <el-form-item label="结构形式" :label-width="formLabelWidth">
                                            <el-select v-model="form.structural_type_id" placeholder="请选择结构类型">
                                                <el-option v-for="(item,index) in structuraltype" :key="index" :label="item.name" :value="item.name"></el-option>
                                            </el-select>
                                        </el-form-item>
                                        <el-form-item label="结构层数" :label-width="formLabelWidth">
                                            <el-input-number v-model="form.structural_floor" @change="handleChange" :min="1" :max="100"></el-input-number>
                                        </el-form-item>
                                        <el-form-item label="监督登记号" :label-width="formLabelWidth">
                                            <el-input v-model="form.item_no" auto-complete="off"></el-input>
                                        </el-form-item>
                                        <el-form-item label="工程号" :label-width="formLabelWidth">
                                            <el-input v-model="form.project_no" auto-complete="off"></el-input>
                                        </el-form-item>
                                        <el-form-item label="国家" :label-width="formLabelWidth">
                                            <el-input v-model="form.country" auto-complete="off"></el-input>
                                        </el-form-item>
                                        <el-form-item label="所在省市区" :label-width="formLabelWidth">
                                            <el-cascader v-model="form.address" :options="citys"></el-cascader>
                                        </el-form-item>
                                        <el-form-item label="详细地址" :label-width="formLabelWidth">
                                            <el-input v-model="form.detail" auto-complete="off"></el-input>
                                        </el-form-item>
                                        <el-form-item label="施工许可证号" :label-width="formLabelWidth">
                                            <el-input v-model="form.permit_no" auto-complete="off"></el-input>
                                        </el-form-item>
                                        <el-form-item label="建筑面积(㎡)" :label-width="formLabelWidth">
                                            <el-input v-model="form.area" auto-complete="off"></el-input>
                                        </el-form-item>
                                        <el-form-item label="投资总金额" :label-width="formLabelWidth">
                                            <el-input v-model="form.total_amount" auto-complete="off"></el-input>
                                        </el-form-item>
                                        <el-form-item label="负责人" :label-width="formLabelWidth">
                                            <el-input v-model="form.chargeman" auto-complete="off"></el-input>
                                        </el-form-item>
                                        <el-form-item label="负责人电话" :label-width="formLabelWidth">
                                            <el-input v-model="form.chargeman_tel" auto-complete="off"></el-input>
                                        </el-form-item>
                                        <el-form-item label="GPS" :label-width="formLabelWidth">
                                            <el-input auto-complete="off" v-model="center.lat+','+center.lng"></el-input>
                                            <el-button type="info" @click="gps">设置GPS</el-button>
                                        </el-form-item>
                                        <div style="padding-top:50px;display: none;" class="gps">
                                            <div @on-cancel="cancel" v-model="showMapComponent" width="400" :closable="false" :mask-closable="false">
                                                <baidu-map v-bind:style="mapStyle" class="bm-view" ak="你的密钥"
                                                        :center="center"
                                                        :zoom="zoom"
                                                        :scroll-wheel-zoom="true"
                                                        @click="getClickInfo"
                                                        @moving="syncCenterAndZoom"
                                                        @moveend="syncCenterAndZoom"
                                                        @zoomend="syncCenterAndZoom">
                                                    <bm-view style="width: 100%; height:300px;"></bm-view>
                                                    <bm-marker :position="{lng: center.lng, lat: center.lat}" :dragging="true" animation="BMAP_ANIMATION_BOUNCE">
                                                    </bm-marker>
                                                    <bm-control offset="{width: '10px', height: '10px'}">
                                                        <bm-auto-complete v-model="keyword" :sugStyle="{zIndex: 999999}">
                                                            <input type="text" placeholder="请输入搜索关键字" class="serachinput">
                                                        </bm-auto-complete>
                                                    </bm-control>
                                                    <bm-local-search :keyword="keyword" :auto-viewport="true" style="width:0px;height:0px;overflow: hidden;"></bm-local-search>
                                                </baidu-map>
                                                <div slot="footer" style="margin-top: 360px;">
                                                    <Button @click="cancel" type="ghost"
                                                            style="width: 60px;height: 36px;">取消
                                                    </Button>
                                                    <Button type="primary" style="width: 60px;height: 36px;" @click="confirm">确定</Button>
                                                </div>
                                            </div>
                                        </div>
                                        <el-form-item label="接收时间" :label-width="formLabelWidth">
                                            <el-date-picker v-model="form.received_at" type="date" placeholder="接收时间">
                                            </el-date-picker>
                                        </el-form-item>
                                        <el-form-item label="开工时间" :label-width="formLabelWidth">
                                            <el-date-picker v-model="form.started_at" type="date" placeholder="开工时间">
                                            </el-date-picker>
                                        </el-form-item>
                                        <el-form-item label="竣工时间" :label-width="formLabelWidth">
                                            <el-date-picker v-model="form.ended_at" type="date" placeholder="竣工时间">
                                            </el-date-picker>
                                        </el-form-item>
                                        <el-form-item label="施工总承包" :label-width="formLabelWidth">
                                            <el-select v-model="form.contract_id" disabled placeholder="">
                                                <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                                            </el-select>
                                            <el-button plain @click="searchUnitBox('contract_id')">...</el-button>
                                        </el-form-item>
                                        <el-form-item label="分包单位" :label-width="formLabelWidth">
                                            <el-select v-model="form.subcontract_id" disabled placeholder="">
                                                <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                                            </el-select>
                                            <el-button plain @click="searchUnitBox('subcontract_id')">...</el-button>
                                        </el-form-item>
                                        <el-form-item label="建设单位" :label-width="formLabelWidth">
                                            <el-select v-model="form.build_id" disabled placeholder="">
                                                <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                                            </el-select>
                                            <el-button plain @click="searchUnitBox('build_id')">...</el-button>
                                        </el-form-item>
                                        <el-form-item label="监理单位" :label-width="formLabelWidth">
                                            <el-select v-model="form.supervisor_id" disabled placeholder="">
                                                <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                                            </el-select>
                                            <el-button plain @click="searchUnitBox('supervisor_id')">...</el-button>
                                        </el-form-item>
                                        <el-form-item label="勘察单位" :label-width="formLabelWidth">
                                            <el-select v-model="form.servey_id" disabled placeholder="">
                                                <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                                            </el-select>
                                            <el-button plain @click="searchUnitBox('servey_id')">...</el-button>
                                        </el-form-item>
                                        <el-form-item label="设计单位" :label-width="formLabelWidth">
                                            <el-select v-model="form.design_id" disabled placeholder="">
                                                <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                                            </el-select>
                                            <el-button plain @click="searchUnitBox('design_id')">...</el-button>
                                        </el-form-item>
                                        <el-form-item label="审图单位" :label-width="formLabelWidth">
                                            <el-select v-model="form.trail_id" disabled placeholder="">
                                                <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                                            </el-select>
                                            <el-button plain @click="searchUnitBox('trail_id')">...</el-button>
                                        </el-form-item>
                                        <el-form-item label="安监站" :label-width="formLabelWidth">
                                            <el-input v-model="form.safety_station_id" auto-complete="off"></el-input>
                                            <el-button plain>...</el-button>
                                        </el-form-item>
                                    </el-form>
                                </el-tab-pane>
                            </el-tabs>
                        </div>
                    </div>
                </div>
            </template>
        </split-pane>


        <el-dialog title="新增项目" :visible.sync="addform" class="pro-add">
            <el-form :model="form">
                <el-form-item label="项目名" :label-width="formLabelWidth">
                    <el-input v-model="form.id" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="项目类型" :label-width="formLabelWidth">
                    <el-select v-model="form.item_category_id" placeholder="请选择项目类型">
                        <el-option v-for="(item,index) in itemcategory" :key="index" :label="item.name" :value="item.name"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="资金来源" :label-width="formLabelWidth">
                    <el-select v-model="form.invest_id" placeholder="请选择资金来源">
                        <el-option v-for="(item,index) in invest" :key="index" :label="item.name" :value="item.name"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="建设方式" :label-width="formLabelWidth">
                    <el-select v-model="form.build_type_id" placeholder="请选择建设方式">
                        <el-option v-for="(item,index) in buildType" :key="index" :label="item.name" :value="item.name"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="结构形式" :label-width="formLabelWidth">
                    <el-select v-model="form.structural_type_id" placeholder="请选择结构类型">
                        <el-option v-for="(item,index) in structuraltype" :key="index" :label="item.name" :value="item.name"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="结构层数" :label-width="formLabelWidth">
                    <el-input-number v-model="form.structural_floor" @change="handleChange" :min="1" :max="100"></el-input-number>
                </el-form-item>
                <el-form-item label="监督登记号" :label-width="formLabelWidth">
                    <el-input v-model="form.item_no" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="工程号" :label-width="formLabelWidth">
                    <el-input v-model="form.project_no" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="国家" :label-width="formLabelWidth">
                    <el-input v-model="form.country" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="所在省市区" :label-width="formLabelWidth">
                    <el-cascader v-model="form.address" :options="citys"></el-cascader>
                </el-form-item>
                <el-form-item label="详细地址" :label-width="formLabelWidth">
                    <el-input v-model="form.detail" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="施工许可证号" :label-width="formLabelWidth">
                    <el-input v-model="form.permit_no" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="建筑面积(㎡)" :label-width="formLabelWidth">
                    <el-input v-model="form.area" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="投资总金额" :label-width="formLabelWidth">
                    <el-input v-model="form.total_amount" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="负责人" :label-width="formLabelWidth">
                    <el-input v-model="form.chargeman" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="负责人电话" :label-width="formLabelWidth">
                    <el-input v-model="form.chargeman_tel" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="GPS" :label-width="formLabelWidth">
                    <el-input auto-complete="off" v-model="center.lat+','+center.lng"></el-input>
                    <el-button type="info" @click="gps">设置GPS</el-button>
                </el-form-item>
                <div style="padding-top:50px;display: none;" class="gps">
                    <div @on-cancel="cancel" v-model="showMapComponent" width="400" :closable="false" :mask-closable="false">
                        <baidu-map v-bind:style="mapStyle" class="bm-view" ak="你的密钥"
                                :center="center"
                                :zoom="zoom"
                                :scroll-wheel-zoom="true"
                                @click="getClickInfo"
                                @moving="syncCenterAndZoom"
                                @moveend="syncCenterAndZoom"
                                @zoomend="syncCenterAndZoom">
                            <bm-view style="width: 100%; height:300px;"></bm-view>
                            <bm-marker :position="{lng: center.lng, lat: center.lat}" :dragging="true" animation="BMAP_ANIMATION_BOUNCE">
                            </bm-marker>
                            <bm-control offset="{width: '10px', height: '10px'}">
                                <bm-auto-complete v-model="keyword" :sugStyle="{zIndex: 999999}">
                                    <input type="text" placeholder="请输入搜索关键字" class="serachinput">
                                </bm-auto-complete>
                            </bm-control>
                            <bm-local-search :keyword="keyword" :auto-viewport="true" style="width:0px;height:0px;overflow: hidden;"></bm-local-search>
                        </baidu-map>
                        <div slot="footer" style="margin-top: 360px;">
                            <Button @click="cancel" type="ghost"
                                    style="width: 60px;height: 36px;">取消
                            </Button>
                            <Button type="primary" style="width: 60px;height: 36px;" @click="confirm">确定</Button>
                        </div>
                    </div>
                </div>
                <el-form-item label="接收时间" :label-width="formLabelWidth">
                    <el-date-picker v-model="form.received_at" type="date" placeholder="接收时间">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="开工时间" :label-width="formLabelWidth">
                    <el-date-picker v-model="form.started_at" type="date" placeholder="开工时间">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="竣工时间" :label-width="formLabelWidth">
                    <el-date-picker v-model="form.ended_at" type="date" placeholder="竣工时间">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="施工总承包" :label-width="formLabelWidth">
                    <el-select v-model="form.contract_id" disabled placeholder="">
                        <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('contract_id')">...</el-button>
                </el-form-item>
                <el-form-item label="分包单位" :label-width="formLabelWidth">
                    <el-select v-model="form.subcontract_id" disabled placeholder="">
                        <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('subcontract_id')">...</el-button>
                </el-form-item>
                <el-form-item label="建设单位" :label-width="formLabelWidth">
                    <el-select v-model="form.build_id" disabled placeholder="">
                        <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('build_id')">...</el-button>
                </el-form-item>
                <el-form-item label="监理单位" :label-width="formLabelWidth">
                    <el-select v-model="form.supervisor_id" disabled placeholder="">
                        <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('supervisor_id')">...</el-button>
                </el-form-item>
                <el-form-item label="勘察单位" :label-width="formLabelWidth">
                    <el-select v-model="form.servey_id" disabled placeholder="">
                        <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('servey_id')">...</el-button>
                </el-form-item>
                <el-form-item label="设计单位" :label-width="formLabelWidth">
                    <el-select v-model="form.design_id" disabled placeholder="">
                        <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('design_id')">...</el-button>
                </el-form-item>
                <el-form-item label="审图单位" :label-width="formLabelWidth">
                    <el-select v-model="form.trail_id" disabled placeholder="">
                        <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('trail_id')">...</el-button>
                </el-form-item>
                <el-form-item label="安监站" :label-width="formLabelWidth">
                    <el-input v-model="form.safety_station_id" auto-complete="off"></el-input>
                    <el-button plain>...</el-button>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="addform = false" style="margin-top:100px;">取 消</el-button>
                <el-button type="primary" @click="ensure">确 定</el-button>
            </div>
        </el-dialog>

        <search-box :chose="chose" v-on:dbClickSelection="getUnitValue" v-on:closeSearchBox="closeUnitValue"></search-box>
    </div>
</template>

<script>
    import splitPane from 'vue-splitpane'
    import { buildType,invest,itemcategory,structuraltype,citys } from "../../api/json"
    import {BaiduMap, BmControl, BmView, BmAutoComplete, BmLocalSearch, BmMarker} from 'vue-baidu-map'
    import SearchBox from '../../components/SearchBox.vue'
    import { getproject,storeproject,editproject,showproject,updateproject,destroyproject} from "../../api/project"
    export default {
        components: {
            BaiduMap,
            BmControl,
            BmView,
            BmAutoComplete,
            BmLocalSearch,
            BmMarker,
            SearchBox,
            splitPane,
        },
        data() {
            return {
                //地图
                showMapComponent: this.value,
                keyword: '',
                mapStyle: {
                    width: '100%',
                    height: this.mapHeight + 'px'
                },
                center: {lng: 113.271429, lat: 23.135336},
                zoom: 15,
                chose: false,
                addform: false,
                formLabelWidth: "100px",
                num1: 1,
                //分页
                currentPage4: 4,
                //建设方式
                buildType: [],
                //资金来源
                invest:[],
                //项目类型
                itemcategory: [],
                //结构形式
                structuraltype:[],
                currentUnitModel: '',    // 当前选择的单位input 的name
                //省市区
                citys:[],
                value1: "",
                value2: "",
                value3: "",
                chose: false,   // 这个是search-box是否显示
                form: {
                    id: '',
                    item_category_id: '',
                    invest_id: '',
                    build_type_id: '',
                    structural_type_id: '',
                    structural_floor: '',
                    item_no: '',
                    project_no: '',
                    country: '',
                    address: [],
                    detail:'',
                    permit_no: '',
                    area: '',
                    total_amount: '',
                    chargeman: '',
                    chargeman_tel: '',
                    gps: '',
                    received_at: '',
                    started_at: '',
                    ended_at: '',
                    contract_id: '',
                    subcontract_id: null,
                    build_id: null,
                    supervisor_id: null,
                    servey_id: null,
                    design_id: null,
                    trail_id: null,
                    safety_station_id: null
                },
                submitType: '',
                unitData: [],
                data: [{
                    label: '坝光片区场平工程(I标段)',
                    children: [{
                        label: '坝光片区场平工程(I标段)',
                    },
                        {
                        label: '坝光片区场平工程(I标段)'
                    }
                        ]
                },
                    {
                    label: '深圳市城市轨道交通3号线南延线工程主体工程3131标段（备份）',
                },
                    {
                    label: '库坑片区路网完善工程新丹路（龙观快速—泗黎路）段工程',
                    children: [{
                        label: '深圳市建泰建筑劳务分包有限公司_黄汉辉(SZJTJZ)'
                    },
                        {
                        label: '中车信息技术有限公司'
                    },
                        {
                            label: '中车信息技术有限公司'
                        }
                    ]
                },
                    {
                        label: '布吉河流域综合治理工程“EPC+O”（设计采购施工和管养一体化）',
                        children: [{
                            label: '湛江市同得利劳务有限公司'
                        },
                            {
                                label: '中车信息技术有限公司'
                            },
                            {
                                label: '深圳市市政工程总公司'
                            },
                            {
                                label: '深圳市聚豪建筑工程劳务分包有限公司'
                            },
                            {
                                label: '深圳市金润劳务工程有限公司'
                            },
                            {
                                label: '深圳市泰屹恒建筑劳务有限公司'
                            },
                            {
                                label: '广东进业劳务分包有限公司'
                            }
                        ]
                    }],
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },
                handleChange(value) {
                    console.log(value)
                },
                gps(){
                    $('.gps').toggle()
                }
            };
        },
        created(){
            buildType().then(res=>{
                this.buildType = res.data.buildtype
            })
            invest().then(res=>{
                this.invest = res.data.invest
            })
            itemcategory().then(res=>{
                this.itemcategory = res.data.itemcategory
            })
            structuraltype().then(res=>{
                this.structuraltype = res.data.structuraltype
            })
            citys().then(res=>{
                this.citys = res.data
            })
            getproject().then(res=>{
                if (res.data.response_status === "success") {
                    this.options = res.data.data
                }
            })
        },
        watch: {
            value: function (currentValue) {
                this.showMapComponent = currentValue
                if (currentValue) {
                    this.keyword = ''
                }
            }
        },
        props: {
            value: Boolean,
            mapHeight: {
                type: Number,
                default: 500
            }
        },
        methods: {
            resize() {
                console.log('resize')
            },
            handleNodeClick(data) {
                console.log(data);
            },
            getClickInfo (e) {
                this.center.lng = e.point.lng
                this.center.lat = e.point.lat
            },
            syncCenterAndZoom (e) {
                const {lng, lat} = e.target.getCenter()
                this.center.lng = lng
                this.center.lat = lat
                this.zoom = e.target.getZoom()
            },
            /***
             * 确认
             */
            confirm: function () {
                this.showMapComponent = false
                this.$emit('map-confirm', this.center)
            },
            /***
             * 取消
             */
            cancel: function () {
                this.showMapComponent = false
                this.$emit('cancel', this.showMapComponent)
            },
            //分页
            handleSizeChange(val) {
                console.log(`每页 ${val} 条`);
            },
            handleCurrentChange(val) {
                console.log(`当前页: ${val}`);
            },
            searchUnitBox(currentUnitModel) {
                this.chose = true
                this.currentUnitModel = currentUnitModel
            },
            getUnitValue(row) {
                console.log(row)
                // this.unitData.push(row)
                this.$set(this.unitData, 0, {label: row.name, value: row.id})
                this.form[this.currentUnitModel] = row.id
                this.chose = false
            },
            closeUnitValue(){
                this.chose = false
            },
           
            handleAdd(){
                this.form={
                    id:'',
                    item_category_id: '',
                    invest_id: '',
                    build_type_id: '',
                    structural_type_id: '',
                    structural_floor: '',
                    item_no: '',
                    project_no: '',
                    country: '',
                    address: [],
                    detail:'',
                    permit_no: '',
                    area: '',
                    total_amount: '',
                    chargeman: '',
                    chargeman_tel: '',
                    gps: '',
                    received_at: '',
                    started_at: '',
                    ended_at: '',
                    contract_id: '',
                    subcontract_id: null,
                    build_id: null,
                    supervisor_id: null,
                    servey_id: null,
                    design_id: null,
                    trail_id: null,
                    safety_station_id: null
                }
                this.addform = true
                this.submitType = 'add'
            },
            handleEdit(){
                console.log(1111)
            },
            ensure(){
                storeproject().then(res => {
                    if(res.data.response_status === 'success') {
                        this.unitData = res.data.data.data
                        this.addform = false
                        this.$message({
                            type: 'success',
                            showClose: true,
                            message: res.data.msg
                        })
                    }
                })
            }
        },

    };
</script>

<style scoped>
    .project .pro-btn{
        padding: 8px 15px;
    }
    .pro-btn .pro-i {
        color: #3a8ee6;
        display: inline-block;
        padding-right: 5px;
    }
    .clearfix:after{
        visibility: hidden;
        display: block;
        height: 0;
        font-size: 0;
        content: "";
        clear: both;
    }
    .clearfix{
        zoom: 1;
    }
    .pro-box{
        width: 100%;
        margin: 0 auto;
    }
    .pro-box-l,.pro-box-r{
        width: 100%;
        overflow: hidden;
    }
    .pro-l-tit{
        width: 100%;
        margin: 5px auto;
        color: #2e6da4;
        background: -webkit-linear-gradient(#f9f5f5, #fff);
        background: -o-linear-gradient(#f9f5f5, #fff);
        background: -moz-linear-gradient(#f9f5f5, #fff);
        background: linear-gradient(#f9f5f5, #fff);
    }
    .pro-l-tit i{
        float: right;
        margin-top: 2px;
        margin-right: 5px;
        color: #2e6da4;
    }
    .pro-l-query{
        width: 100%;
        margin: 20px auto;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    .query .el-input__inner{
        height: 30px;
    }
    .query-text{
        margin-top: 5px;
    }
    .query-text i{
        margin-right: 5px;
        color: #2e6da4;
    }
    .el-input{
        width: 70%;
    }
    .pro-add .el-form-item{
        float: left;
        width: 50%;
    }
    .el-input.el-input--suffix{
        width: 100%;
    }
    .serachinput{
        width: 300px;
        box-sizing: border-box;
        padding: 9px;
        border: 1px solid #dddee1;
        line-height: 20px;
        font-size: 16px;
        height: 38px;
        color: #333;
        position: relative;
        border-radius: 4px;
        -webkit-box-shadow: #666 0px 0px 10px;
        -moz-box-shadow: #666 0px 0px 10px;
        box-shadow: #666 0px 0px 10px;
    }
    .chose-name i{
        display: inline-block;
        margin-right: 5px;
        margin-left: 5px;
    }
    .par-r-name{
        display: inline-block;
        margin-right: 10px;
    }
    .par-r-name .el-input__inner{
        float: left;
    }
    .pro-search{
        float: right;
        margin-right: 30px;
    }
    .pro-box-r .el-form-item{
        float: left;
        width: 50%;
    }
</style>


