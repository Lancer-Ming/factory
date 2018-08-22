<template>
    <div class="container dust">
        <el-row style="margin-top: 20px;">
            <el-button type="primary"  icon="el-icon-plus" size="mini" style="border-radius: 8px;margin-left: 20px;" @click="handleAdd">新增</el-button>
            <el-button type="primary" plain icon="el-icon-edit" size="mini" style="border-radius: 8px;" @click="handleEdit">编辑</el-button>
            <el-button type="danger" icon="el-icon-delete" size="mini" style="border-radius: 8px;" @click="handleDelete">删除</el-button>
            <el-button type="warning" plain icon="el-icon-download" size="mini" style="border-radius: 8px;">下载</el-button>
        </el-row>
        <el-row style="margin-top: 20px;"  class="dust-form">
            <el-form :model="query" size="mini">
                <el-form-item label="SN" :label-width="formLabelW">
                    <el-input  auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="监测点" :label-width="formLabelW">
                    <el-input  auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="监测站名称" :label-width="formLabelW">
                    <el-input  auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="是否在线" :label-width="formLabelW">
                    <el-select v-model="query.is_online" placeholder="请选择活动区域">
                        <el-option label="是" value="是"></el-option>
                        <el-option label="否" value="否"></el-option>
                    </el-select>
                </el-form-item>
                <el-button type="primary" plain size="mini" style="float: left" @click="search">查询</el-button>
                <el-button size="mini" style="float: left">清空</el-button>
            </el-form>
        </el-row>
        <el-table class="crane-tab"
                :data="tableData"
                border
                stripe
                style="width: 100%;"
                @selection-change="handleSelectionChange"
        >
            <el-table-column
                    prop="id"
                    align="center"
                    width="40"
                    fixed
                    sortable
                    label="#"
            >
                <template slot-scope="scope">
                    <span>{{ scope.row.id }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    align="center"
                    type="selection"
                    width="30"
                    fixed
            >
            </el-table-column>
            <el-table-column
                    fixed
                    prop=""
                    label="SN"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="监测站名称"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="floor_no"
                    label="监控点名称"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="扬尘监控"
                    width="80"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="PM10"
                    width="80"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="PM25"
                    width="80"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="噪声监控"
                    width="80"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="温度监控"
                    width="80"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="风速监控"
                    width="80"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="风向监控"
                    width="80"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="风向监控"
                    width="80"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="is_online"
                    label="SIM卡号"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="is_online"
                    label="欠费提醒"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="is_online"
                    label="最近上线时间"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="is_online"
                    label="是否在线"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="is_monitor"
                    label="监控状态"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    fixed="right"
                    label="操作"
                    width="150"
                    align="center"
            >
                <template slot-scope="scope">
                    <el-button type="primary" plain size="mini">设置GPS</el-button>
                </template>
            </el-table-column>
        </el-table>



        <el-dialog v-dialogDrag :visible.sync="dustAdd">
            <div slot="title">
                <span class="el-dialog__title">新增塔机信息</span>
                <button class="el-dialog_btn__fullscreen">
                </button>
            </div>
            <el-form :model="form" size="mini">
                <h4 style="display: block;margin: 30px auto;text-align: center;font-weight: bold;">设备信息</h4>
                <el-form-item label="所在项目" :label-width="formLabelWidth">
                    <el-select v-model="form.item_id" placeholder="请选择所在项目" disabled>
                        <el-option label="" value=""></el-option>
                    </el-select>
                    <el-button plain>...</el-button>
                </el-form-item>
                <el-form-item label="监控点名称" :label-width="formLabelWidth">
                    <el-input v-model="form.record_no" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="产权单位" :label-width="formLabelWidth">
                    <el-select v-model="form.right_id" placeholder="请选择产权单位" disabled>
                        <el-option label="" value=""></el-option>
                    </el-select>
                    <el-button plain>...</el-button>
                </el-form-item>
                <el-form-item label="是否监控" :label-width="formLabelWidth">
                    <el-switch v-model="form.is_monitor">
                    </el-switch>
                </el-form-item>

                <h4 style="display: block;margin: 30px auto;text-align: center;font-weight: bold;">扬尘噪声监控设备信息</h4>
                <el-form-item label="黑匣子SN" :label-width="formLabelWidth">
                    <el-input v-model="form.sn" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="设备型号" :label-width="formLabelWidth">
                    <el-input v-model="form.install_unit_id" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="安装单位" :label-width="formLabelWidth">
                    <el-select v-model="form.item_id" placeholder="请选择所在项目" disabled>
                        <el-option label="" value=""></el-option>
                    </el-select>
                    <el-button plain>...</el-button>
                </el-form-item>
                <el-form-item label="安装日期" :label-width="formLabelWidth">
                    <el-date-picker
                            v-model="form.installed_at"
                            type="date"
                            placeholder="选择安装日期"  format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="拆卸日期" :label-width="formLabelWidth">
                    <el-date-picker
                            v-model="form.installed_at"
                            type="date"
                            placeholder="选择拆卸日期"  format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="SIM" :label-width="formLabelWidth">
                    <el-input v-model="form.GPRS" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="有效期(月)" :label-width="formLabelWidth">
                    <el-input v-model="form.validity_month" auto-complete="off" readonly placeholder="10"></el-input>
                </el-form-item>
                <el-form-item label="续费日期" :label-width="formLabelWidth">
                    <el-date-picker
                            v-model="form.paid_at"
                            type="date"
                            placeholder="选择缴费日期"  format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="功能配置" :label-width="formLabelWidth" style="width: 100%;">
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.weight">扬尘</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.range">PM10</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.rotation">PM2.5</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.height">露点</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.wind">气压</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.angle">湿度</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.collision">温度</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.control">噪音</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.gps">GPS</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.gps">风向</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.gps">风速</el-checkbox>
                </el-form-item>
                <el-form-item label="备注" :label-width="formLabelWidth" style="width: 100%;">
                    <el-input
                            type="textarea"
                            :rows="2"
                            placeholder="请输入内容"
                            v-model="form.parameters.remarks">
                    </el-input>
                </el-form-item>
                <el-form-item label="监测点照片" :label-width="formLabelWidth">
                    <el-upload
                            action="https://jsonplaceholder.typicode.com/posts/"
                            list-type="picture-card"
                            :on-preview="handlePictureCardPreview"
                            :on-remove="handleRemove">
                        <i class="el-icon-plus"></i>
                    </el-upload>
                    <el-dialog :visible.sync="Monitoring">
                        <img width="100%" :src="dialogImageUrl" alt="">
                    </el-dialog>
                </el-form-item>

            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="craneAdd = false">取 消</el-button>
                <el-button type="primary" @click="confirm">确 定</el-button>
            </div>
        </el-dialog>


    </div>
</template>

<script>
    export default {
        data(){
            return{
                query:{
                    is_online:''
                },
                option: [{
                    value: '选项1',
                    label: '平臂'
                }, {
                    value: '选项2',
                    label: '动臂'
                }],
                options: [{
                    value1: '选项1',
                    label1: '2'
                }, {
                    value1: '选项2',
                    label1: '4'
                }],
                form:{
                    id: '',
                    item_id: '',
                    right_id: '',
                    crane_produce_id: '',
                    is_monitor: true,
                    driver: '',
                    record_no: '',
                    floor_no: '',
                    c_model: '',
                    left_no: '',
                    parameters: {
                        lifting_weight: '',
                        rated_torque: '',
                        tower_crane: '',
                        top_tower: '',
                        forearm_length: '',
                        posterior_length: '',
                        localX: '',
                        localY: '',
                        tower_type: '',
                        multiple_rate: '',
                        remarks: ''
                    },
                    left_at: '',
                    install_unit_id: '',
                    crane_id: '',
                    sn: '',
                    GPRS: '',
                    validity_month: '',
                    model:　'',
                    paid_at: '',
                    installed_at: '',
                    function_config: {
                        weight: '',
                        range: '',
                        rotation: '',
                        height: '',
                        wind: '',
                        angle: '',
                        collision: '',
                        control: '',
                        gps: ''
                    },
                    identify: {
                        identification: '',
                        card: '',
                        fingerprint: '',
                        recognition: ''
                    }
                },
                formLabelW: '100px',
                tableData: [],
                dustAdd: false,
                formLabelWidth: '120px',
                dialogImageUrl: '',
                Monitoring: false,
            }
        },
        methods:{
            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePictureCardPreview(file) {
                this.Monitoring = file.url;
                this.Monitoring = true;
            },
            handleAdd(){
                this.dustAdd = true
            },
            handleEdit(){

            },
            handleDelete(){

            },
            handleSelectionChange(){

            },
            search(){

            },
            confirm(){

            }

        }
    }
</script>

<style>
    .dust-form .el-form-item{
        width: 30%;
        float: left;
        padding-right: 60px;
    }
</style>