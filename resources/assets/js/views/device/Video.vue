<template>
    <div class="container video" style="position: relative;height: 100%;">
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
                        <el-col :span="11"><el-input size="mini" v-model="d_name" style="width: 100%;margin-top: 5px;"></el-input></el-col>
                        <el-col :span="2">&nbsp;</el-col>
                        <el-col :span="9" class="query-text"><el-button type="warning" icon="el-icon-search" plain size="mini">查询</el-button></el-col>
                    </el-row>
                    <el-row>
                        <li v-for="(item,index) in data" :key="index" v-text="item.label" @click="handleNodeClick(item)" class="text-els" :class="{ 'item-list': activeItemId === item.id }" style="cursor: pointer;"></li>
                        <!--<el-tree :data="data" show-checkbox check-on-click-node :props="defaultProps" :highlight-current="true" node-key="id" @node-click="handleNodeClick" ref="tree"></el-tree>-->
                    </el-row>
                </div>
            </template>
            <template slot="paneR">
                <div class="right-container">
                    <el-row style="background: rgba(233,242,255,.5);padding: 5px 20px;">
                        <el-button type="primary" plain size="mini" icon="el-icon-circle-plus-outline" class="v-btn" @click="handleAdd">添加摄像头</el-button>
                        <el-button type="primary" plain size="mini" icon="el-icon-sort" class="v-btn" @click="copySelectForm">复制添加摄像头</el-button>
                        <el-button type="primary" plain size="mini" icon="el-icon-success" class="v-btn" @click="handleBroadcast">开通直播/获取地址</el-button>
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
                            @row-click="cellClick"
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
                                prop="hls"
                                label="HLS播放地址（流畅）"
                                width="600"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="rtmp"
                                label="rtmpHd播放地址（流畅）"
                                width="600"
                                align="center"
                        >
                        </el-table-column>
                        <el-table-column
                                fixed="right"
                                label="操作"
                                width="100"
                                align="center"
                        >
                            <template slot-scope="scope">
                                <el-button type="danger" size="mini" icon="el-icon-delete" @click="destroyDevice(scope.row)">删除</el-button>
                            </template>
                        </el-table-column>
                    </el-table>

                    <el-pagination
                        @size-change="handleSizeChange"
                        @current-change="handleCurrentChange"
                        :current-page="currentPage"
                        :page-sizes="perPagesize"
                        :page-size="pagesize"
                        layout="total, sizes, prev, pager, next, jumper"
                        :total="total"
                        align="center"
                        style="margin-top: 20px;"
                        >
                    </el-pagination>
                </div>
            </template>
        </split-pane>

        <el-dialog title="添加摄像头" :visible.sync="addCamera" class="addCamera">
            <el-form :model="form">

                <el-form-item label="摄像头名称" :label-width="formLabelWidth">
                    <span style="float: left;position: absolute;top: 2px;left: -93px;color: red;">*</span>
                    <el-tooltip class="item" effect="dark" content="60个合法字符以内" placement="top">
                        <el-input v-model="form.d_name" auto-complete="off" size="mini"></el-input>
                    </el-tooltip>
                </el-form-item>
                <el-form-item label="设备序列号" :label-width="formLabelWidth">
                    <span style="float: left;position: absolute;top: 2px;left: -93px;color: red;">*</span>
                    <el-input v-model="form.serial" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="设备通道号" :label-width="formLabelWidth">
                    <span style="float: left;position: absolute;top: 2px;left: -93px;color: red;">*</span>
                    <el-input v-model="form.channel_no" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="设备验证码" :label-width="formLabelWidth">
                    <span style="float: left;position: absolute;top: 2px;left: -93px;color: red;">*</span>
                    <el-input v-model="form.validate_code" placeholder="设备机身上的六位大写字母" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="安装日期" :label-width="formLabelWidth">
                    <el-date-picker v-model="form.install_at" size="mini" type="date" placeholder="安装日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="负责人" :label-width="formLabelWidth">
                    <el-input v-model="form.chargeman" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="负责人手机号" :label-width="formLabelWidth">
                    <el-input v-model="form.chargeman_tel" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="萤石云账号" :label-width="formLabelWidth">
                    <el-input v-model="form.username" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="萤石云密码" :label-width="formLabelWidth">
                    <el-input v-model="form.password" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="手机号" :label-width="formLabelWidth">
                    <el-input v-model="form.phone" auto-complete="off" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="有效期时间戳" :label-width="formLabelWidth">
                    <span style="float: left;position: absolute;top: 2px;left: -110px;color: red;">*</span>
                    <el-input v-model="form.expiretime" auto-complete="off" size="mini" :readonly="true"></el-input>
                </el-form-item>
                <el-form-item label="萤石云AppKey" :label-width="formLabelWidth">
                    <span style="float: left;position: absolute;top: 2px;left: -115px;color: red;">*</span>
                    <el-tooltip class="item" effect="dark" content="请输入萤石云我的应用下的应用秘钥AppKey" placement="top">
                        <el-input v-model="form.appkey" auto-complete="off" size="mini"></el-input>
                    </el-tooltip>
                </el-form-item>
                <el-form-item label="萤石云Secret" :label-width="formLabelWidth" style="width: 100%;">
                    <span style="float: left;position: absolute;top: 2px;left: -105px;color: red;">*</span>
                    <el-tooltip class="item" effect="dark" content="请输入萤石云我的应用下的应用秘钥Secret" placement="top">
                        <el-input v-model="form.secret" auto-complete="off" size="mini"></el-input>
                    </el-tooltip>
                </el-form-item>
                <el-form-item label="萤石云AccessToken" :label-width="formLabelWidth" style="width: 100%;">
                    <span style="float: left;position: absolute;top: 2px;left: -150px;color: red;">*</span>
                    <el-tooltip class="item" effect="dark" content="请输入萤石云我的应用下的应用秘钥AccessToken" placement="top">
                        <el-input v-model="form.access_token" auto-complete="off" style="width: 78%" size="mini" :readonly="true" @focus="autoGetAccessToken"></el-input>
                    </el-tooltip>
                        <el-button type="warning" plain size="mini" @click="getAccessToken" v-show="tokenBtnVisible">获取AccessToken</el-button>
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
                <el-button @click="addCamera = false">取 消</el-button>
                <el-button type="warning" @click="confirm">确 定</el-button>
            </div>
        </el-dialog>

    </div>
</template>
<script>
    import splitPane from 'vue-splitpane'
    import { getproject} from "../../api/project"
    import { addDeviceTolocal, getAccessToken, autoGetAccessToken, showDivice, addDevice, destroyDevice, destroyDeviceToLocal,openBroadcast,getBroadcastAddress, updateBroadcastAddress } from "../../api/videoDevice"
    import { perPagesize } from '../../config/common'
    import { implode } from '../../utils/common'
    export default {
        components: {
            splitPane,
        },
        data() {
            return {
                activeItemId: null,
                addCamera: false,
                tokenBtnVisible: false,
                form:{
                    id: '',
                    d_name: '',
                    serial: '',
                    channel_no: null,
                    validate_code: '',
                    install_at: '',
                    chargeman: '',
                    chargeman_tel: '',
                    ezopen: '',
                    hls_address: '',
                    rtmp_address: '',
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
                submitType: '',
                defaultProps: {
                    children: 'id',
                    label: 'label'
                },
                tableData: [],
                multipleSelection: {},
                // 分页
                loading: true,
                currentPage: 1,
                pagesize: 10,
                name: '',
                total: null,
                // 模糊查询
                d_name: ''
            }
        },
        created(){
            getproject().then(res=>{
                if (res.data.response_status === "success") {
                    let data = []
                    res.data.data.forEach(item => {
                        data.push({label: item.name, id: item.id})
                    })
                    this.data = data
                    this.getDevices(this.data[0].id, this.d_name)
                    this.activeItemId = this.data[0].id
                    this.form.item_id = this.activeItemId
                }
            })
        },
        methods:{
            resize() {
                console.log('resize')
            },
            handleSelectionChange(val) {
                this.multipleSelection = val;
            },
            handleNodeClick(data) {
                this.activeItemId = data.id
                this.form.item_id = data.id
                let showData = {
                    item_id: data.id,
                }
                this.getDevices(data.id, this.d_name)
            },
            handleAdd(){
                this.form={
                    id: '',
                    d_name: '',
                    serial: '',
                    channel_no: '',
                    validate_code: '',
                    install_at: '',
                    chargeman: '',
                    chargeman_tel: '',
                    hls_address: '',
                    rtmp_address: '',
                    appkey: '',
                    secret: '',
                    access_token: '',
                    username: '',
                    password: '',
                    phone: '',
                    expiretime: '',
                    item_id: this.form.item_id
                }
                this.addCamera = true
                this.submitType= 'add'
            },
            confirm(){
                let data = this.form
                addDevice({accessToken: data.access_token, deviceSerial: data.serial, validateCode: data.validate_code}).then(res => {
                    if(res.data.code === "200"){
                        data.pagesize = this.pagesize
                        addDeviceTolocal(data).then(res=>{
                            if(res.data.response_status === 'success') {
                                this.addCamera = false
                                this.tableData = res.data.data.data
                                this.$message({
                                    type: 'success',
                                    showClose: true,
                                    message: res.data.msg
                                })
                                this.addCamera = false
                            }
                        })
                    } else {
                        this.$message({
                            type: 'error',
                            showClose: true,
                            message: res.data.msg
                        })
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
                    this.tokenBtnVisible = true
                })
            },
            getDevices(item_id, d_name=null) {
                showDivice({page: this.currentPage, pagesize: this.pagesize, item_id, d_name }).then(res => {
                    if (res.data.response_status === 'success') {
                        this.tableData = res.data.data.data
                    }
                })
            },
            // 分页
            handleSizeChange(pagesize) {
                this.pagesize = pagesize
                this.getTableData()
            },
            handleCurrentChange(currentPage) {
                this.getTableData(currentPage)
            },
            // 表格
            cellClick(row) {
                this.$refs.multipleTable.toggleRowSelection(row)
            },
            implode(arr, attr) {
                return implode(arr, attr);
            },
            // 删除摄像头
            destroyDevice(row) {
                console.log(row)
                this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    destroyDevice({accessToken: row.ys.access_token,deviceSerial:row.serial}).then(res => {
                        if(res.data.code === "200"){
                            destroyDeviceToLocal(row.id, {pagesize: this.pagesize, item_id: this.activeItemId}).then(res => {
                                if (res.data.response_status === 'success') {
                                    this.tableData = res.data.data.data
                                    this.$message({
                                        type: 'success',
                                        showClose: true,
                                        message: res.data.msg
                                    })
                                }
                            })
                        } else {
                            this.$message({
                                type: 'error',
                                showClose: true,
                                message: res.data.msg
                            })
                        }
                    })
                }).catch(() => {
                    return
                })
            },
            handleBroadcast(){
                let arr = this.multipleSelection
                if (arr.length === 0) {
                    this.$message({
                        type: 'warning',
                        showClose: true,
                        message: '请勾选后再做尝试！'
                    })                   
                    return
                }
                let resault = []
                arr.forEach(function(item){
                    resault.push(`${item.serial}:${item.channel_no}`)
                });
                let source = resault.toString()

                this.$confirm('此操作将开通直播，是否继续?','提示',{
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'success',
                    center: true
                }).then(() => {
                    openBroadcast({accessToken: this.multipleSelection[0].ys.access_token,source}).then(res=>{
                        if (res.data.code !== '200') {
                            this.$message({
                                type: 'warning',
                                showClose: true,
                                message: res.data.msg,
                            })
                            return
                        }
                        // 判断是否所有设备都开通成功
                        let isAllSuccess = true
                        const errorDevice = []
                        res.data.data.forEach(item => {
                            item.ret !== '200' ? isAllSuccess = false : ''
                            errorDevice.push({deviceSerial: item.deviceSerial, desc: item.desc})
                        })

                        if(res.data.code === "200" && isAllSuccess){
                            getBroadcastAddress({accessToken: this.multipleSelection[0].ys.access_token,source}).then(r => {
                                if(r.data.code === "200"){
                                    r.data.item_id = this.activeItemId
                                    r.data.pagesize = this.pagesize
                                    updateBroadcastAddress(r.data).then(response => {
                                        if(response.data.response_status === 'success'){
                                            this.tableData = response.data.data.data
                                            this.$message({
                                                type: 'success',
                                                showClose: true,
                                                message: response.data.msg
                                            })
                                        }
                                    })
                                }
                            })
                        } else {
                            let html = ''
                            errorDevice.forEach(item => {
                                html += `<li style="list-style: none;">序列号号为${item.deviceSerial}的设备，${item.desc}</li>`
                            })
                            this.$message({
                                type: 'warning',
                                showClose: true,
                                message: html,
                                dangerouslyUseHTMLString: true
                            })
                        }
                    })
                })
            },
            copySelectForm() {
                this.form={
                    d_name: this.multipleSelection.d_name,
                    serial: this.multipleSelection.serial,
                    channel_no: this.multipleSelection.channel_no,
                    validate_code: this.multipleSelection.validate_code,
                    install_at: this.multipleSelection.updated_at,
                    chargeman: this.multipleSelection.chargeman,
                    chargeman_tel: this.multipleSelection.chargeman_tel,
                    appkey: this.multipleSelection.ys.appkey,
                    secret: this.multipleSelection.ys.secret,
                    access_token: this.multipleSelection.ys.access_token,
                    username: this.multipleSelection.ys.username,
                    password: this.multipleSelection.ys.password,
                    phone: this.multipleSelection.ys.phone,
                    expiretime: this.multipleSelection.ys.expiretime,
                    item_id: this.form.item_id
                }
                this.addCamera = true
                this.submitType= 'add'
            }
        },
        computed: {
            perPagesize() {
                return perPagesize
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
    .left-container li{
        display: block;
        padding: 10px 10px;
    }
    .item-list{
        background: #eee;
    }
</style>