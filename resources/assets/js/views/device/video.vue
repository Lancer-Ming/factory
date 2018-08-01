<template>
    <div class="container" style="position: relative;height: 100%;">
        <split-pane v-on:resize="resize" split="vertical" :default-percent='20' :min-percent='10' :max-percent='30' class="projectBox" style="background: #fff">
            <template slot="paneL">
                <div class="left-container">
                   <div class="video-tit">
                        <el-row>
                            <i class="el-icon-d-arrow-left tool" style="color: #8fbafe;float: right;"></i>
                        </el-row>
                   </div>
                    <el-row class="vide-l-query">
                        <el-col :span="2">&nbsp;</el-col>
                        <el-col :span="11"><el-input size="mini" style="width: 100%;margin-top: 5px;"></el-input></el-col>
                        <el-col :span="2">&nbsp;</el-col>
                        <el-col :span="9" class="query-text"><el-button type="warning" icon="el-icon-search" plain size="mini">查询</el-button></el-col>
                    </el-row>
                    <el-row>
                        <el-tree :data="data" :props="defaultProps" :highlight-current="true" @node-click="handleNodeClick"></el-tree>
                    </el-row>
                </div>
            </template>
            <template slot="paneR">
                <div class="right-container">
                    <el-row style="background: rgba(233,242,255,.5);padding: 5px 20px;">
                        <el-button type="primary" plain size="mini" icon="el-icon-circle-plus-outline" class="v-btn" @click="addCamera = true">添加摄像头</el-button>
                        <el-button type="primary" plain size="mini" icon="el-icon-sort" class="v-btn">复制添加摄像头</el-button>
                        <el-button type="primary" plain size="mini" icon="el-icon-delete" class="v-btn">删除摄像头</el-button>
                    </el-row>
                    <el-row style="margin: 20px 0px 0px 20px;">
                        摄像头名称：<el-input size="mini" style="width: 30%;"></el-input>
                        <el-button type="warning" plain class="pro-search" size="mini" icon="el-icon-search">搜索</el-button>
                    </el-row>
                    <el-table
                            ref="multipleTable"
                            :data="tableData3"
                            tooltip-effect="dark"
                            style="width: 100%;margin-top: 30px;"
                            @selection-change="handleSelectionChange"
                    >
                        <el-table-column
                                type="index"
                                width="50"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                type="selection"
                                width="55"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="name"
                                label="摄像头名称"
                                width="150"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="number"
                                label="设备序列号"
                                width="120"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="v_number"
                                label="设备通道号"
                                width="100"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="address"
                                label="直播源地址（EZOPEN协议，流畅）"
                                width="450"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="hls"
                                label="HLS播放地址（流畅）"
                                width="600"
                                align="center"
                                >
                        </el-table-column>
                    </el-table>
                </div>
            </template>
        </split-pane>

        <el-dialog title="添加摄像头" :visible.sync="addCamera" class="addCamera">
            <el-form :model="form">
                <el-form-item label="*摄像头名称" :label-width="formLabelWidth">
                    <el-input v-model="form.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="*设备序列号" :label-width="formLabelWidth">
                    <el-input v-model="form.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="*设备通道号" :label-width="formLabelWidth">
                    <el-input v-model="form.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="*萤石云AppKey" :label-width="formLabelWidth">
                    <el-input v-model="form.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="*萤石云Secret" :label-width="formLabelWidth" style="width: 100%;">
                    <el-input v-model="form.name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="*萤石云AccessToken" :label-width="formLabelWidth" style="width: 100%;">
                    <el-input v-model="form.name" auto-complete="off" style="width: 78%"></el-input>
                    <el-button type="warning" plain>获取AccessToken</el-button>
                </el-form-item>
                <el-form-item label="*EZOPEN直播源" :label-width="formLabelWidth" style="width: 100%;">
                    <el-input v-model="form.name" disabled auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="*HLS播放地址" :label-width="formLabelWidth" style="width: 100%;">
                    <el-input v-model="form.name" disabled auto-complete="off"></el-input>
                </el-form-item>
            </el-form>
            <div class="attention">
                <h3>注意事项:</h3>
                <p>
                    （1）这里的摄像头配置信息，来自于莹石云开放平台“https://open.ys7.com”；<br />
                    （2）项目端摄像头需要先在萤石云平台上进行注册、配置；<br />
                    （3）本功能仅支持海康的摄像头；<br />
                </p>
            </div>
            <div slot="footer" class="dialog-footer" style="text-align: center;">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="warning" @click="dialogFormVisible = false">确 定</el-button>
            </div>
        </el-dialog>

    </div>
</template>
<script>
    import splitPane from 'vue-splitpane'
    import { getproject} from "../../api/project"
    import { addDevice,addDeviceTolocal } from "../../api/videoDevice"
    export default {
        components: {
            splitPane,
        },
        data() {
            return {
                addCamera: false,
                form:{
                    id: '',
                    d_name: '',
                    serial: '',
                    validate_code: '',
                    ezopen: '',
                    hls_address: '',
                    accessToken: '',
                    deviceSerial: '',
                    validateCode: ''
                },
                formLabelWidth: '150px',
                unitData: [],
                data: [],
                editData: {},
                accessToken: '',
                deviceSerial: '',
                validateCode: '',
                defaultProps: {
                    children: 'children',
                    label: 'name'
                },
                tableData3: [{
                    name: '坝光环境3号球机',
                    number: 'C20322236',
                    v_number: '1',
                    address: 'ezopen://open.ys7.com/C20322236/1.live',
                    hls: 'http://hls.open.ys7.com/openlive/6778c087ad564b2ab7b13016c17ec7c3.m3u8'
                },
                    {
                    name: '坝光环境1号球机',
                    number: 'C14837868',
                    v_number: '1',
                    address: 'ezopen://open.ys7.com/C14837868/1.live',
                    hls: 'http://hls.open.ys7.com/openlive/b8735bbf5c0c4db8942b176644230b04.m3u8'
                },
                    {
                    name: '坝光环境2号球机',
                    number: 'C20322513',
                    v_number: '1',
                    address: 'ezopen://open.ys7.com/C20322513/1.live',
                    hls: 'http://hls.open.ys7.com/openlive/82d2e511fb2d472c815e6026a334399d.m3u8'
                }],
                multipleSelection: [],
                }
            },
        created(){
            getproject().then(res=>{
                if (res.data.response_status === "success") {
                    this.data = res.data.data
                }
            })
        },
        methods:{
            resize() {
                console.log('resize')
            },
            toggleSelection(rows) {
                if (rows) {
                    rows.forEach(row => {
                        this.$refs.multipleTable.toggleRowSelection(row);
                    });
                } else {
                    this.$refs.multipleTable.clearSelection();
                }
            },
            handleSelectionChange(val) {
                this.multipleSelection = val;
            },
            handleNodeClick(data) {
                if (this.editData.id === data.id) {
                    return
                }
                // this.editData = data
                // this.editId = data.id
                // this.form = this.editData
                // let units = this.editData.units[0].pivot
                // delete units.item_id
                // let units_ids = Object.values(units)
                // console.log(units_ids)
                // var result = units_ids.filter(val => {
                //     return val !== null
                // })
            },
        }
    }
</script>
<style scoped>
    .left-container{
        height: 100%;
        width: 100%;
        overflow: hidden;
    }
    .right-container{
        height: 100%;
    }
    .video-tit{
        width:100%;
        padding: 10px 5px;
        background: #E0ECFF;
    }
    .vide-l-query{
        width: 100%;
        margin: 20px auto;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    .v-btn{
        border-radius: 15px;
    }
    .addCamera .el-form-item{
        float: left;
        width: 50%;
    }
    .attention{
        width: 100%;
        margin: 50% auto 20px auto;
        background: #fff9ec;
        color: #ff9c24;
        display: block;
        padding: 10px 10px;
    }
    .attention p{
        line-height: 30px;
        font-size: 14px;
        margin-top: 5px;
    }
</style>