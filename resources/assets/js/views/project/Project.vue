<template>
    <div class="container content-container project">
        <div class="toolsbar">
            <el-row class="btnBox">
                <el-button size="mini" round  @click="handleAdd"><i class="el-icon-circle-plus-outline pro-i"></i>新增项目</el-button>
                <el-button size="mini" round  @click="handleDeleteSeleted"><i class="el-icon-remove-outline pro-i"></i>移除</el-button>
                <el-button size="mini" round  @click=""><i class="el-icon-circle-plus-outline pro-i"></i>添加参建单位</el-button>
                <el-button size="mini" round  @click=""><i class="el-icon-refresh pro-i"></i>同步数据</el-button>
            </el-row>
        </div>
        <split-pane v-on:resize="resize" split="vertical" :default-percent='20' :min-percent='10' :max-percent='30' class="projectBox">
            <template slot="paneL">
                <div class="left-container">
                    <div class="pro-box clearfix">
                        <div class="pro-box-l clearfix">
                            <el-row class="pro-l-tit clearfix">
                                <el-col :span="20" style="font-weight: bold;">项目/单位名称</el-col>
                                <i class="el-icon-d-arrow-left tool"></i>
                            </el-row>
                            <el-row class="pro-l-query">
                                <el-col :span="12"><el-input v-model="unitSearchValue" class="query" size="mini" style="width: 100%;"></el-input></el-col>
                                <el-col :span="3">&nbsp;</el-col>
                                <el-button :span="9" type="mini" class="query-text" @click="unitSearch"><i class="el-icon-search"></i>查询</el-button>
                            </el-row>
                            <el-row>
                                <el-tree :data="data" :props="defaultProps" :highlight-current="true" @node-click="handleNodeClick"></el-tree>
                            </el-row>
                        </div>
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
                                    <el-form :model="form">
                                        <el-form-item label="项目名" :label-width="formLabelWidth">
                                            <el-input v-model="form.name" auto-complete="off"></el-input>
                                        </el-form-item>
                                        <el-form-item label="项目类型" :label-width="formLabelWidth">
                                            <el-select v-model="form.item_category_id" placeholder="请选择项目类型">
                                                <el-option v-for="(item,index) in itemcategory" :key="index" :label="item.name" :value="item.id"></el-option>
                                            </el-select>
                                        </el-form-item>
                                        <el-form-item label="资金来源" :label-width="formLabelWidth">
                                            <el-select v-model="form.invest_id" placeholder="请选择资金来源">
                                                <el-option v-for="(item,index) in invest" :key="index" :label="item.name" :value="item.id"></el-option>
                                            </el-select>
                                        </el-form-item>
                                        <el-form-item label="建设方式" :label-width="formLabelWidth">
                                            <el-select v-model="form.build_type_id" placeholder="请选择建设方式">
                                                <el-option v-for="(item,index) in buildType" :key="index" :label="item.name" :value="item.id"></el-option>
                                            </el-select>
                                        </el-form-item>
                                        <el-form-item label="结构形式" :label-width="formLabelWidth">
                                            <el-select v-model="form.structural_type_id" placeholder="请选择结构类型">
                                                <el-option v-for="(item,index) in structuraltype" :key="index" :label="item.name" :value="item.id"></el-option>
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
                                            <el-input auto-complete="off" v-model="form.gps"></el-input>
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
                                                <div slot="footer" style="margin: 360px 0px 20px 0px;">
                                                    <el-button @click="cancel" style="width: 70px;height: 38px;">取消
                                                    </el-button>
                                                    <el-button type="primary" style="width: 70px;height: 38px;" @click="confirm">确定</el-button>
                                                </div>
                                            </div>
                                        </div>
                                        <el-form-item label="接收时间" :label-width="formLabelWidth">
                                            <el-date-picker v-model="form.received_at" type="date" placeholder="接收时间" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                                            </el-date-picker>
                                        </el-form-item>
                                        <el-form-item label="开工时间" :label-width="formLabelWidth">
                                            <el-date-picker v-model="form.started_at" type="date" placeholder="开工时间" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                                            </el-date-picker>
                                        </el-form-item>
                                        <el-form-item label="竣工时间" :label-width="formLabelWidth">
                                            <el-date-picker v-model="form.ended_at" type="date" placeholder="竣工时间" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
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
                                            <el-select v-model="form.safety_station_id" disabled placeholder="">
                                                <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                                            </el-select>
                                            <el-button plain @click="searchUnitBox('safety_station_id')">...</el-button>
                                        </el-form-item>
                                        <el-button type="warning" plain icon="el-icon-check" style="margin:20px auto;display: block;text-align: center;" @click="editSubmit">保存</el-button>
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
                    <el-input v-model="form.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="项目类型" :label-width="formLabelWidth">
                    <el-select v-model="form.item_category_id" placeholder="请选择项目类型">
                        <el-option v-for="(item,index) in itemcategory" :key="index" :label="item.name" :value="item.id"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="资金来源" :label-width="formLabelWidth">
                    <el-select v-model="form.invest_id" placeholder="请选择资金来源">
                        <el-option v-for="(item,index) in invest" :key="index" :label="item.name" :value="item.id"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="建设方式" :label-width="formLabelWidth">
                    <el-select v-model="form.build_type_id" placeholder="请选择建设方式">
                        <el-option v-for="(item,index) in buildType" :key="index" :label="item.name" :value="item.id"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="结构形式" :label-width="formLabelWidth">
                    <el-select v-model="form.structural_type_id" placeholder="请选择结构类型">
                        <el-option v-for="(item,index) in structuraltype" :key="index" :label="item.name" :value="item.id"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="结构层数" :label-width="formLabelWidth" class="stru">
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
                    <el-input auto-complete="off" v-model="form.gps"></el-input>
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
                        <div slot="footer" style="margin: 360px 0px 20px 0px;">
                            <el-button @click="cancel" style="width: 70px;height: 38px;">取消</el-button>
                            <el-button type="primary" style="width: 70px;height: 38px;" @click="confirm">确定</el-button>
                        </div>
                    </div>
                </div>
                <el-form-item label="接收时间" :label-width="formLabelWidth">
                    <el-date-picker v-model="form.received_at" type="date" placeholder="接收时间" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="开工时间" :label-width="formLabelWidth">
                    <el-date-picker v-model="form.started_at" type="date" placeholder="开工时间" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="竣工时间" :label-width="formLabelWidth">
                    <el-date-picker v-model="form.ended_at" type="date" placeholder="竣工时间" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
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
                    <el-select v-model="form.safety_station_id" disabled placeholder="">
                        <el-option v-for="item in unitData" :key="item.value" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('safety_station_id')">...</el-button>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="addform = false" style="margin-top:100px;">取 消</el-button>
                <el-button type="primary" @click="ensure">确 定</el-button>
            </div>
        </el-dialog>

        <el-dialog title="弹出选择" :visible.sync="Safety">
            <div style="width: 60%;margin: -20px 0px 10px 0px;" class="chose-name">
                名称：<el-input size="mini"></el-input>
                <i class="el-icon-search"></i><span>查询</span>
                <i class="el-icon-delete"></i><span>清空</span>
            </div>
            <el-table
                    :data="tableData"
                    border
                    style="width: 100%">
                <el-table-column
                        prop="date"
                        type="index"
                        width="100"
                        align="center"
                >
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="名称"
                        width="300"
                        align="center"
                >
                </el-table-column>
                <el-table-column
                        prop="address"
                        label="地址"
                        align="center"
                        width="500"
                >
                </el-table-column>
                <el-table-column
                        prop="person"
                        label="联系人"
                        align="center"
                        width="500"
                >
                </el-table-column>
                <el-table-column
                        prop="tell"
                        label="电话"
                        align="center"
                        width="500"
                >
                </el-table-column>
            </el-table>
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage4"
                    :page-sizes="[100, 200, 300, 400]"
                    :page-size="100"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="400"
                    align="center"
                    style="margin-top: 20px;"
            >
            </el-pagination>
            <div slot="footer" class="dialog-footer">
                <el-button @click="Safety = false">取 消</el-button>
                <el-button type="primary" @click="Safety = false">确 定</el-button>
            </div>
        </el-dialog>

        <search-box :chose="chose" :currentUnitModel="currentUnitModel" v-on:dbClickSelection="getUnitValue" v-on:closeSearchBox="closeUnitValue"></search-box>

    </div>
</template>

<script>
    import splitPane from 'vue-splitpane'
    import { buildType,invest,itemcategory,structuraltype,citys } from "../../api/json"
    import {BaiduMap, BmControl, BmView, BmAutoComplete, BmLocalSearch, BmMarker} from 'vue-baidu-map'
    import SearchBox from '../../components/SearchBox.vue'
    import { getproject,storeproject,editproject,showproject,updateproject,destroyproject, findUnit} from "../../api/project"
    import { implode } from '../../utils/common'
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
                tableData: [],
                unitSearchValue: '',
                //地图
                showMapComponent: this.value,
                keyword: '',
                mapStyle: {
                    width: '100%',
                    height: this.mapHeight + 'px'
                },
                center: {lng: 113.273154, lat: 23.14278},
                zoom: 15,
                chose: false,
                addform: false,
                Safety: false,
                formLabelWidth: "100px",
                label:'',
                editData: {},
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
                    name: '',
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
                data: [],
                defaultProps: {
                    children: 'units',
                    label: 'name'
                },
                gpsData: '',
                defaultGps: {
                    lng: 113.273154, lat: 23.14278,
                },
                editId: null,
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
                    this.data = res.data.data
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
            },
            handleNodeClick(data) {
                if (this.editData.id === data.id) {
                    return
                }
                this.editData = data
                this.editId = data.id
                this.form = this.editData
                this.$set(this.form, 'contract_id', implode(data.units, 'id')[0])
                this.$set(this.form, 'subcontract_id', data.units[0]['pivot']['subcontract_id'])
                this.$set(this.form, 'build_id', data.units[0]['pivot']['build_id'])
                this.$set(this.form, 'design_id', data.units[0]['pivot']['design_id'])
                this.$set(this.form, 'servey_id', data.units[0]['pivot']['servey_id'])
                this.$set(this.form, 'supervisor_id', data.units[0]['pivot']['supervisor_id'])
                this.$set(this.form, 'trail_id', data.units[0]['pivot']['trail_id'])
                this.$set(this.form, 'safety_station_id', data.units[0]['pivot']['safety_station_id'])
                this.$set(this.form, 'address',  [this.editData.province, this.editData.city, this.editData.county])

                // 拿到单位的id
                let units = this.editData.units[0].pivot
                delete units.item_id
                let units_ids = Object.values(units)
                var result = units_ids.filter(val => {
                    return val !== null
                })
                this.editData['units_ids'] = result
                findUnit(result).then(res => {
                    if (res.data.response_status === 'success') {
                        this.unitData = res.data.data
                    }
                })

                // 初始化gps
                this.$set(this.center, 'lng', this.editData.gps ? this.editData.gps.split(',')[0] : this.defaultGps.lng)
                this.$set(this.center, 'lat', this.editData.gps ? this.editData.gps.split(',')[1] : this.defaultGps.lat)
                this.form.gps = this.center.lng + ',' + this.center.lat
            },
            getClickInfo (e) {
                this.$set(this.center, 'lng', e.point.lng)
                this.$set(this.center, 'lat', e.point.lat)
                this.$set(this.form, 'gps', this.center.lng + ',' + this.center.lat)
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
                $('.gps').toggle()
            },
            /***
             * 取消
             */
            cancel: function () {
                // this.showMapComponent = false
                this.form.gps = this.gpsData
                this.center.lng = this.gpsData.split(',')[0]
                this.center.lat = this.gpsData.split(',')[1]
                this.$emit('cancel', this.showMapComponent)
                $('.gps').hide()
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
                this.$set(this.unitData, 0, {label: row.name, value: row.id})
                this.form[this.currentUnitModel] = row.id
                this.chose = false
            },
            closeUnitValue(){
                this.chose = false
            },
            handleAdd(){
                this.form={
                    name:'',
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
                console.log(2222)
                this.submitType = 'edit'
                if (this.label !== "") {
                    editproject(this.label.label).then(res => {
                        // this.editData = res.data.data
                        // this.form = this.editData
                    })
                }
            },
            editSubmit() {
                let data = this.form
                data.province = this.form.address[0]
                data.city = this.form.address[1]
                data.county = this.form.address[2]
                delete data.id
                updateproject(this.editId, data).then(res => {
                    if(res.data.response_status === 'success') {
                        this.data = res.data.data
                        this.$message({
                            type: 'success',
                            showClose: true,
                            message: res.data.msg
                        })
                    }
                })
            },
            ensure(){
                let data = this.form
                data.province = this.form.address[0]
                data.city = this.form.address[1]
                data.county = this.form.address[2]
                storeproject(data).then(res => {
                    if(res.data.response_status === 'success') {
                        this.data = res.data.data
                        this.addform = false
                        this.$message({
                            type: 'success',
                            showClose: true,
                            message: res.data.msg
                        })
                    }
                })
            },
            handleDeleteSeleted(){
                this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    destroyproject(this.editId, this.editData.units_ids).then(res => {
                        this.data = res.data.data
                        this.$message({
                            type: 'success',
                            showClose: true,
                            message: res.data.msg
                        })
                    })
                }).catch(() => {
                    return
                })
            },
            handleChange(value) {
            },
            gps(){
                this.gpsData = this.center.lng + ',' + this.center.lat
                $('.gps').toggle()
            },
            unitSearch() {
                getproject({name: this.unitSearchValue}).then(res => {
                    if (res.data.response_status === "success") {
                        this.data = res.data.data
                    }
                })
            }
        },

    };
</script>

