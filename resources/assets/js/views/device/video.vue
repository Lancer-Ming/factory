<template>
    <div class="container" style="position: relative;height: 100%;">
        <split-pane v-on:resize="resize" split="vertical" :default-percent='20' :min-percent='10' class="projectBox" style="background: #fff;">
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
                        <el-button type="primary" plain size="mini" icon="el-icon-circle-plus-outline" class="v-btn" @click="handleAdd">添加摄像头</el-button>
                        <el-button type="primary" plain size="mini" icon="el-icon-sort" class="v-btn">复制添加摄像头</el-button>
                        <el-button type="primary" plain size="mini" icon="el-icon-delete" class="v-btn">删除摄像头</el-button>
                    </el-row>
                    <el-row style="margin: 20px 0px 0px 20px;">
                        摄像头名称：<el-input size="mini" style="width: 30%;"></el-input>
                        <el-button type="warning" plain class="pro-search" size="mini" icon="el-icon-search">搜索</el-button>
                    </el-row>
                    <el-table
                            ref="multipleTable"
                            :data="tableData"
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
                                prop="d_name"
                                label="摄像头名称"
                                width="150"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="serial"
                                label="设备序列号"
                                width="120"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="channel_no"
                                label="设备通道号"
                                width="100"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="ezopen"
                                label="直播源地址（EZOPEN协议，流畅）"
                                width="450"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="hls_address"
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
                    <el-input v-model="form.d_name" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="*设备序列号" :label-width="formLabelWidth">
                    <el-input v-model="form.serial" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="*设备通道号" :label-width="formLabelWidth">
                    <el-input v-model="form.channel_no" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="*设备验证码" :label-width="formLabelWidth">
                    <el-input v-model="form.validate_code" placeholder="设备机身上的六位大写字母" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="*安装日期" :label-width="formLabelWidth">
                    <el-date-picker v-model="form.install_at" size="mini" type="date" placeholder="安装日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="*负责人" :label-width="formLabelWidth">
                    <el-input v-model="form.chargeman" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="*负责人手机号" :label-width="formLabelWidth">
                    <el-input v-model="form.chargeman_tel" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="*萤石云账号" :label-width="formLabelWidth">
                    <el-input v-model="form.username" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="*萤石云密码" :label-width="formLabelWidth">
                    <el-input v-model="form.password" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="*手机号" :label-width="formLabelWidth">
                    <el-input v-model="form.phone" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="*有效期时间戳" :label-width="formLabelWidth">
                    <el-input v-model="form.expiretime" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="*萤石云AppKey" :label-width="formLabelWidth">
                    <el-input v-model="form.appkey" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="*萤石云Secret" :label-width="formLabelWidth" style="width: 100%;">
                    <el-input v-model="form.secret" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="*萤石云AccessToken" :label-width="formLabelWidth" style="width: 100%;">
                    <el-input v-model="form.access_token" auto-complete="off" style="width: 78%" size="mini" :readonly="true" @focus="autoGetAccessToken"></el-input>
                    <el-button type="warning" plain size="mini" @click="getAccessToken" v-show="tokenBtnVisible">获取AccessToken</el-button>
                </el-form-item>
                <el-form-item label="*EZOPEN直播源" :label-width="formLabelWidth" style="width: 100%;">
                    <el-input v-model="form.ezopen" disabled auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="*HLS播放地址" :label-width="formLabelWidth" style="width: 100%;">
                    <el-input v-model="form.hls_address" disabled auto-complete="off" size="mini"></el-input>
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
                <el-button type="warning" @click="confirm">确 定</el-button>
            </div>
        </el-dialog>

    </div>
</template>
<script>
    import splitPane from 'vue-splitpane'
    import { getproject} from "../../api/project"
    import { addDevice,addDeviceTolocal,getAccessToken, autoGetAccessToken } from "../../api/videoDevice"
    export default {
        components: {
            splitPane,
        },
        data() {
            return {
                addCamera: false,
                tokenBtnVisible: false,
                form:{
                    id: '',
                    d_name: '',
                    serial: '',
                    channel_no: '',
                    validate_code: '',
                    install_at: '',
                    chargeman: '',
                    chargeman_tel: '',
                    ezopen: '',
                    hls_address: '',
                    appkey: '',
                    secret: '',
                    access_token: '',
                    username: '',
                    password: '',
                    phone: '',
                    expiretime: '',
                    item_id: null,
                },
                formLabelWidth: '150px',
                unitData: [],
                data: [],
                accessToken: '',
                deviceSerial: '',
                validateCode: '',
                submitType: '',
                defaultProps: {
                    children: 'children',
                    label: 'name'
                },
                tableData: [],
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
                this.form.item_id = data.id
            },
            handleAdd(){
                this.from={
                    id: '',
                    d_name: '',
                    serial: '',
                    channel_no: '',
                    validate_code: '',
                    install_at: '',
                    chargeman: '',
                    chargeman_tel: '',
                    ezopen: '',
                    hls_address: '',
                    appkey: '',
                    secret: '',
                    access_token: '',
                    username: '',
                    password: '',
                    phone: '',
                    expiretime: ''
                }
                this.addCamera = true
                this.submitType= 'add'
            },
            confirm(){
                let data = this.form
                addDevice(data).then(res=>{
                    if(res.data.response_status === 'success') {
                        this.addCamera = false
                        this.tableData = res.data.data
                    }
                })
                addDeviceTolocal(data).then(res=>{
                    if(res.data.response_status === 'success') {
                        this.addCamera = false
                        this.tableData = res.data.data
                    }
                })
            },
            getAccessToken(){
                let appKey = this.form.appkey
                let appSecret = this.form.secret
                getAccessToken({appKey,appSecret}).then(res=>{
                    if(res.data.code === "200"){
                        this.$set(this.form,"access_token",res.data.data.accessToken)
                        this.$set(this.form,"expiretime",res.data.data.expireTime)
                        this.$message({
                            type: 'success',
                            showClose: true,
                            message: res.data.msg
                        })
                        this.tokenBtnVisible = false
                    }
                })

            },
            autoGetAccessToken() {
                if (this.form.access_token || this.tokenBtnVisible) {
                    return
                }
                let appKey = this.form.appkey
                let appSecret = this.form.secret
                autoGetAccessToken({appKey,appSecret}).then(res => {
                    if (res.data.data.status === 1) {
                        this.tokenBtnVisible = false
                        this.$set(this.form,"access_token",res.data.data.accessToken)
                        this.$set(this.form,"expiretime",res.data.data.expireTime)
                        this.$message({
                            type: 'success',
                            showClose: true,
                            message: '操作成功！'
                        })
                    } else {
                        this.tokenBtnVisible = true
                    }
                }).catch(error => {
                    this.$message({
                        type: 'error',
                        showClose: true,
                        message: 'AppKey或者是Secret填写错误'
                    })
                })
            },
            test() {
                console.log(13)
            }
        }
    }
</script>
<style scoped>
    .left-container{
        height: 100%;
        width: 100%;

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
        margin: 80% auto 20px auto;
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