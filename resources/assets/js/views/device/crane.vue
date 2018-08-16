<template>
    <div class="container crane">
        <el-row style="margin-top: 20px;">
            <el-button type="primary"  icon="el-icon-plus" size="mini" style="border-radius: 8px;" @click="handleAdd">新增</el-button>
            <el-button type="primary" plain icon="el-icon-edit" size="mini" style="border-radius: 8px;">编辑</el-button>
            <el-button type="danger" icon="el-icon-delete" size="mini" style="border-radius: 8px;">删除</el-button>
            <el-button type="warning" plain icon="el-icon-download" size="mini" style="border-radius: 8px;">下载</el-button>
        </el-row>
        <el-row style="margin-top: 20px;">
            <el-form :model="form" size="mini" class="crane-head">
                <el-form-item label="项目名称" :label-width="formLabelW">
                    <el-input auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="产权单位" :label-width="formLabelW">
                    <el-input  auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="备案编号" :label-width="formLabelW">
                    <el-input  auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="黑匣子SN" :label-width="formLabelW">
                    <el-input  auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="是否在线" :label-width="formLabelW">
                    <el-select v-model="form.region" placeholder="请选择活动区域">
                        <el-option label="是" value="shanghai"></el-option>
                        <el-option label="否" value="beijing"></el-option>
                    </el-select>
                </el-form-item>
                <el-button type="primary" plain size="mini" style="float: left">查询</el-button>
                <el-button size="mini" style="float: left">清空</el-button>
            </el-form>
        </el-row>
        <el-table class="crane-tab"
                :data="tableData"
                border
                stripe
                style="width: 100%;">
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
                    fixed
                    prop="SN"
                    label="SN"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="number"
                    label="备案编号"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="塔机名称"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="project"
                    label="所在项目"
                    width="300"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="tell"
                    label="SIM卡号"
                    width="200"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="remind"
                    label="欠费提醒"
                    width="300"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="data"
                    label="最近上线时间"
                    width="200"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="collision"
                    label="防碰撞"
                    width="60"
                    align="center"
            >
                <template slot-scope="scope">
                    <el-checkbox v-model="checked2" disabled></el-checkbox>
                </template>
            </el-table-column>
            <el-table-column
                    prop="online"
                    label="是否在线"
                    width="100"
                    align="center"
            >
                <template slot-scope="scope">
                    <el-checkbox v-model="checked1" disabled></el-checkbox>
                </template>
            </el-table-column>
            <el-table-column
                    prop="state"
                    label="监控状态"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    fixed="right"
                    label="操作"
                    width="200"
                    align="center"
            >
                <template slot-scope="scope">
                    <el-button @click="handleClick(scope.row)" type="primary" plain size="mini">远程断电</el-button>
                    <el-button type="primary" plain size="mini">设置GPS</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-row>
            <el-row style="margin-top: 20px;">
                <el-pagination
                        @size-change="handleSizeChange"
                        @current-change="handleCurrentChange"
                        :current-page="currentPage"
                        :page-sizes="[100, 200, 300, 400]"
                        :page-size="100"
                        layout="total, sizes, prev, pager, next, jumper"
                        :total="400"
                        align="center"
                >
                </el-pagination>
            </el-row>
        </el-row>


        <el-dialog title="新增塔机信息" :visible.sync="craneAdd">
            <el-form :model="form" size="mini">

                <h4 style="margin-left:45%;font-weight: bold;">塔机信息</h4>
                <el-form-item label="所在项目" :label-width="formLabelWidth">
                    <el-select v-model="form.item_id" placeholder="请选择所在项目" disabled>
                        <el-option v-for="(item,index) in items" :label="item.label" :key="index" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('item')">...</el-button>
                </el-form-item>
                <el-form-item label="产权单位" :label-width="formLabelWidth">
                    <el-select v-model="form.right_id" placeholder="请选择产权单位" disabled>
                        <el-option v-for="(item,index) in units" :label="item.label" :key="index" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('unit','right_id')">...</el-button>
                </el-form-item>
                <el-form-item label="生产厂商单位" :label-width="formLabelWidth">
                    <el-select v-model="form.crane_produce_id" placeholder="请选择生产产商" disabled>
                        <el-option v-for="(item,index) in units" :label="item.label" :key="index" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('unit','crane_produce_id')">...</el-button>
                </el-form-item>
                <el-form-item label="备案编号" :label-width="formLabelWidth">
                    <el-input v-model="form.record_no" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="楼号" :label-width="formLabelWidth">
                    <el-input v-model="form.floor_no" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="塔吊型号" :label-width="formLabelWidth">
                    <el-input v-model="form.c_model" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="塔吊出厂编号" :label-width="formLabelWidth">
                    <el-input v-model="form.left_no" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="出厂日期" :label-width="formLabelWidth">
                    <el-date-picker
                            v-model="form.left_at"
                            type="date"
                            placeholder="选择出厂日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="塔机ID" :label-width="formLabelWidth">
                    <el-input v-model="form.crane_id" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="是否监控" :label-width="formLabelWidth">
                    <el-switch v-model="form.is_monitor">
                    </el-switch>
                </el-form-item>

                <h4 style="margin:30px 0px 20px 45%;font-weight: bold;">黑匣子信息</h4>
                <el-form-item label="黑匣子SN" :label-width="formLabelWidth">
                    <el-input v-model="form.sn" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="安装单位" :label-width="formLabelWidth">
                    <el-input v-model="form.install_unit_id" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="黑匣子GPRS" :label-width="formLabelWidth">
                    <el-input v-model="form.GPRS" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="有效日期" :label-width="formLabelWidth">
                    <el-input v-model="form.validity_month" auto-complete="off" readonly placeholder="10"></el-input>
                </el-form-item>
                <el-form-item label="黑匣子型号" :label-width="formLabelWidth">
                    <el-input v-model="form.model" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="续费日期" :label-width="formLabelWidth">
                    <el-date-picker
                            v-model="form.paid_at"
                            type="date"
                            placeholder="选择缴费日期"  format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="安装日期" :label-width="formLabelWidth">
                    <el-date-picker
                            v-model="form.installed_at"
                            type="date"
                            placeholder="选择安装日期"  format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item>&nbsp;</el-form-item>
                <el-form-item label="功能配置" :label-width="formLabelWidth" style="width: 100%;">
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.weight">重量</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.range">幅度</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.rotation">回转</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.height">高度</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.wind">风速</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.angle">倾角</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.collision">防碰撞</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.control">继电器输出控制</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.function_config.gps">GPS</el-checkbox>
                </el-form-item>
                <el-form-item label="身份识别" :label-width="formLabelWidth" style="width: 100%;">
                    <el-checkbox style="width: 100%;margin-left: 30px;" v-model="form.identify.identification">司机识别</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.identify.card">IC打卡</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.identify.fingerprint ">指纹打卡</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.identify.recognition">人脸识别</el-checkbox>
                </el-form-item>

                <h4 style="margin:30px 0px 20px 45%;font-weight: bold;">塔机参数</h4>
                <el-form-item label="最大吊重" :label-width="formLabelWidth">
                    <el-input v-model="form.parameters.lifting_weight" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="额定力矩" :label-width="formLabelWidth">
                    <el-input v-model="form.parameters.rated_torque" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="塔吊高" :label-width="formLabelWidth">
                    <el-input v-model="form.parameters.tower_crane" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="塔顶高" :label-width="formLabelWidth">
                    <el-input v-model="form.parameters.top_tower" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="前臂长" :label-width="formLabelWidth">
                    <el-input v-model="form.parameters.forearm_length" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="后臂长" :label-width="formLabelWidth">
                    <el-input v-model="form.parameters.posterior_length" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="局部坐标X" :label-width="formLabelWidth">
                    <el-input v-model="form.parameters.localX" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="局部坐标Y" :label-width="formLabelWidth">
                    <el-input v-model="form.parameters.localY" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="塔臂类型" :label-width="formLabelWidth">
                    <el-select v-model="form.parameters.tower_type" placeholder="请选择">
                        <el-option
                                v-for="item in option"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="倍率" :label-width="formLabelWidth">
                    <el-select v-model="form.parameters.multiple_rate" placeholder="请选择">
                        <el-option
                                v-for="item in options"
                                :key="item.value1"
                                :label="item.label1"
                                :value="item.value1">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="备注" :label-width="formLabelWidth" style="width: 100%;">
                    <el-input
                            type="textarea"
                            :rows="2"
                            placeholder="请输入内容"
                            v-model="form.parameters.remarks">
                    </el-input>
                </el-form-item>

                <h4 style="margin:30px 0px 20px 45%;font-weight: bold;">司机证书</h4>
                <div style="width: 800px;border: 1px solid #eee;margin-left: 50px;">
                    <el-form-item label="司机" :label-width="formLabel" style="margin-top: 20px;">
                        <el-select v-model="form.driver" placeholder="" disabled>
                            <el-option label="" value=""></el-option>
                        </el-select>
                        <el-button plain @click="searchDriver">...</el-button>
                    </el-form-item>
                    <el-table
                            :data="tableData3"
                            height="250"
                            border
                            style="width: 100%">
                        <el-table-column  width="60"></el-table-column>
                        <el-table-column
                                prop="name"
                                label="姓名"
                                width="150"
                                align="center"
                        >
                        </el-table-column>
                        <el-table-column
                                prop="Opera_type"
                                label="操作类型"
                                width="150"
                                align="center"
                        >
                        </el-table-column>
                        <el-table-column
                                prop="number"
                                label="证书编号"
                                width="140"
                                align="center"
                        >
                        </el-table-column>
                        <el-table-column
                                prop="data"
                                label="发证日期"
                                width="150"
                                align="center"
                        >
                        </el-table-column>
                        <el-table-column
                                prop="validity"
                                label="有效期至"
                                width="150"
                                align="center"
                        >
                        </el-table-column>
                    </el-table>
                </div>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="craneAdd = false">取 消</el-button>
                <el-button type="primary" @click="confirm">确 定</el-button>
            </div>
        </el-dialog>



        <search-box :chose="chose" v-on:dbClickSelection="getUnitValue" v-on:closeSearchBox="closeUnitValue" :requestName="requestName" :currentUnitModel="currentUnitModel"></search-box>
    </div>
</template>

<script>
    import SearchBox from '../../components/SearchBox.vue'
    import { getcrane,editcrane,updatecrane,destroycrane,storecrane } from '../../api/crane'
    export default {
        components:{
            SearchBox
        },
        data() {
            return {
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
                items: [],
                units: [],
                currentUnitModel: "",
                formLabel: '70px',
                formLabelW: '75px',
                formLabelWidth: '120px',
                tableData: [{
                    SN: 104666,
                    name: '#1',
                    project: '中铁隧道集团科技大厦',
                    tell: 1064687974918,
                    remind: '[续费或更换卡号]剩余9个月',
                    data: '2018-08-13 13:00:46',
                    state: '监控中',
                },
                    {
                        SN: 104666,
                        name: '#1',
                        project: '中铁隧道集团科技大厦',
                        tell: 1064687974918,
                        remind: '[续费或更换卡号]剩余9个月',
                        data: '2018-08-13 13:00:46',
                        state: '监控中',
                    }
                ],
                currentPage: 4,
                checked1: false,
                checked2: true,
                craneAdd: false,
                chose: false,
                requestName: '',
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
                value: '',
                value1: '',
                tableData3: [{
                    name: '',
                    Opera_type: '',
                    number: '',
                    data: '',
                    validity: ''
                }]
            }
        },
        // created(){
        //     getcrane().then(res =>{
        //         if(res.data.response_status === 'success'){
        //             console.log(res)
        //         }
        //     })
        // },
        methods: {
            handleClick(row) {
                console.log(row);
            },
            handleSizeChange(val) {
                console.log(`每页 ${val} 条`);
            },
            handleCurrentChange(val) {
                console.log(`当前页: ${val}`);
            },
            handleAdd(){
                this.form={
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
                }
                this.craneAdd = true
                this.submitType = 'add'
            },
            searchUnitBox(requestName,currentUnitModel) {
                this.chose = true
                this.requestName = requestName
                this.currentUnitModel = currentUnitModel
            },
            getUnitValue(row){
                this.chose = false
                if(this.requestName === 'item'){
                    this.$set(this.items, 0, {label: row.name, value: row.id})
                    this.$set(this.form, 'item_id', row.id)
                }else{
                    this.$set(this.units, 0, {label: row.name, value: row.id})
                    this.form[this.currentUnitModel] = row.name
                }
            },
            closeUnitValue(){
                this.chose = false
            },
            searchDriver(){

            },
            confirm(){
                let data = this.form
                data.item_id = parseInt(data.item_id)
                data.right_id = parseInt(data.right_id)
                data.crane_produce_id = parseInt(data.crane_produce_id)
                data.is_monitor = parseInt(data.is_monitor)
                data.install_unit_id = parseInt(data.install_unit_id)
                data.validity_month = parseInt(data.validity_month)
                data.model = parseInt(data.model)
                data.parameters = JSON.stringify(data.parameters)
                data.function_config =  JSON.stringify(data.function_config)
                data.identify =  JSON.stringify(data.identify)
                storecrane(data).then(res =>{
                    if (res.data.response_status === 'success') {
                        console.log(res)
                        // this.data = res.data.data
                        // this.addform = false
                        // this.$message({
                        //     type: 'success',
                        //     showClose: true,
                        //     message: res.data.msg
                        // })
                    }
                })
            }
        }
    }

</script>

<style>
    .crane-head .el-form-item{
        width: 30%;
        float: left;
        padding-right: 60px;
    }
    .crane-tab .el-table__row{
        height: 35px;
    }
</style>