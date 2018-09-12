<template>
    <div class="container dust">
        <el-row style="margin-top: 20px;">
            <el-button type="primary" icon="el-icon-plus" size="mini" style="border-radius: 8px;margin-left: 20px;" @click="handleAdd">新增</el-button>
            <el-button type="primary" plain icon="el-icon-edit" size="mini" style="border-radius: 8px;" @click="handleEdit">编辑</el-button>
            <el-button type="danger" icon="el-icon-delete" size="mini" style="border-radius: 8px;" @click="handleDelete">删除</el-button>
            <el-button type="warning" plain icon="el-icon-download" size="mini" style="border-radius: 8px;">下载</el-button>
        </el-row>
        <el-row style="margin-top: 20px;" class="dust-form">
            <el-form :model="query" size="mini">
                <el-form-item label="SN" :label-width="formLabelW">
                    <el-input auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="所在项目" :label-width="formLabelW">
                    <el-input auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="监控点名称" :label-width="formLabelW">
                    <el-input auto-complete="off"></el-input>
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
        <el-table
                class="crane-tab"
                :data="tableData"
                border
                stripe
                @selection-change="handleSelectionChange"
                :default-sort="{prop: 'id', order: 'ascending'}"
                @row-click="cellClick"
                @row-dblclick="dblclick"
                ref="table"
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
                    prop="sn"
                    label="SN"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="station_name"
                    label="所在项目"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="monitor_place_name"
                    label="监控点名称"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="func_config.dust"
                    label="扬尘监控"
                    width="80"
                    align="center"
            >
                <template slot-scope="scope">
                    <i class="el-icon-check" style="color:#588d31;" v-show="JSON.parse(scope.row.func_config).dust"></i>
                    <i class="el-icon-close" style="color:#aa3f3f;" v-show="!JSON.parse(scope.row.func_config).dust"></i>
                </template>
            </el-table-column>
            <el-table-column
                    prop="func_config.pm10"
                    label="PM10"
                    width="80"
                    align="center"
            >
                <template slot-scope="scope">
                    <i class="el-icon-check" style="color:#588d31;" v-show="JSON.parse(scope.row.func_config).pm10"></i>
                    <i class="el-icon-close" style="color:#aa3f3f;" v-show="!JSON.parse(scope.row.func_config).pm10"></i>
                </template>
            </el-table-column>
            <el-table-column
                    prop="func_config.pm2"
                    label="PM25"
                    width="80"
                    align="center"
            >
                <template slot-scope="scope">
                    <i class="el-icon-check" style="color:#588d31;" v-show="JSON.parse(scope.row.func_config).pm2"></i>
                    <i class="el-icon-close" style="color:#aa3f3f;" v-show="!JSON.parse(scope.row.func_config).pm2"></i>
                </template>
            </el-table-column>
            <el-table-column
                    prop="func_config.noise"
                    label="噪声监控"
                    width="80"
                    align="center"
            >
                <template slot-scope="scope">
                    <i class="el-icon-check" style="color:#588d31;" v-show="JSON.parse(scope.row.func_config).noise"></i>
                    <i class="el-icon-close" style="color:#aa3f3f;" v-show="!JSON.parse(scope.row.func_config).noise"></i>
                </template>
            </el-table-column>
            <el-table-column
                    prop="func_config.temperature"
                    label="温度监控"
                    width="80"
                    align="center"
            >
                <template slot-scope="scope">
                    <i class="el-icon-check" style="color:#588d31;" v-show="JSON.parse(scope.row.func_config).temperature"></i>
                    <i class="el-icon-close" style="color:#aa3f3f;" v-show="!JSON.parse(scope.row.func_config).temperature"></i>
                </template>
            </el-table-column>
            <el-table-column
                    prop="func_config.wind_speed"
                    label="风速监控"
                    width="80"
                    align="center"
            >
                <template slot-scope="scope">
                    <i class="el-icon-check" style="color:#588d31;" v-show="JSON.parse(scope.row.func_config).wind_speed"></i>
                    <i class="el-icon-close" style="color:#aa3f3f;" v-show="!JSON.parse(scope.row.func_config).wind_speed"></i>
                </template>
            </el-table-column>
            <el-table-column
                    prop="func_config.wind_direction"
                    label="风向监控"
                    width="80"
                    align="center"
            >
                <template slot-scope="scope">
                    <i class="el-icon-check" style="color:#588d31;" v-show="JSON.parse(scope.row.func_config).wind_direction"></i>
                    <i class="el-icon-close" style="color:#aa3f3f;" v-show="!JSON.parse(scope.row.func_config).wind_direction"></i>
                </template>
            </el-table-column>
            <el-table-column
                    prop="SIM_card"
                    label="SIM卡号"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="valid_month"
                    label="欠费提醒"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="recent_time"
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
                <template slot-scope="scope">
                    <span>{{ scope.row.is_online == 1 ? '√' : '×' }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    prop="is_monitor"
                    label="监控状态"
                    width="120"
                    align="center"
            >
                <template slot-scope="scope">
                    <span v-if="scope.row.is_monitor == 1">
                        <i class="el-icon-check" style="color:#588d31;"></i>
                    </span>
                    <span v-else>
                        <i class="el-icon-close" style="color:#aa3f3f;"></i>
                    </span>
                </template>
            </el-table-column>
            <el-table-column
                    fixed="right"
                    label="操作"
                    width="150"
                    align="center"
            >
                <template slot-scope="scope">
                    <el-button type="primary" plain size="mini" v-show="JSON.parse(scope.row.func_config).wind_direction">设置GPS</el-button>
                </template>
            </el-table-column>
        </el-table>
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
                        <el-option v-for="(item,index) in items" :label="item.label" :key="index" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('item')">...</el-button>
                </el-form-item>
                <el-form-item label="监控点名称" :label-width="formLabelWidth">
                    <el-input v-model="form.monitor_place_name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="产权单位" :label-width="formLabelWidth">
                    <el-select v-model="form.right_id" placeholder="请选择产权单位" disabled>
                        <el-option v-for="(item,index) in units" :label="item.label" :key="index" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('unit','right_id')">...</el-button>
                </el-form-item>
                <el-form-item label="是否监控" :label-width="formLabelWidth">
                    <el-switch v-model="form.is_monitor">
                    </el-switch>
                </el-form-item>

                <h4 style="display: block;margin: 30px auto;text-align: center;font-weight: bold;">扬尘噪声监控设备信息</h4>
                <el-form-item label="扬尘噪声SN" :label-width="formLabelWidth">
                    <el-input v-model="form.sn" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="设备型号" :label-width="formLabelWidth">
                    <el-input v-model="form.d_model" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="安装单位" :label-width="formLabelWidth">
                    <el-select v-model="form.install_id" placeholder="请选择所在项目" disabled>
                        <el-option v-for="(item,index) in units" :label="item.label" :key="index" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('unit','install_id')">...</el-button>
                </el-form-item>
                <el-form-item label="安装日期" :label-width="formLabelWidth">
                    <el-date-picker
                            v-model="form.installed_at"
                            type="date"
                            placeholder="选择安装日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="拆卸日期" :label-width="formLabelWidth">
                    <el-date-picker
                            v-model="form.disassembled_at"
                            type="date"
                            placeholder="选择拆卸日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="SIM" :label-width="formLabelWidth">
                    <el-input v-model="form.SIM_card" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="有效期(月)" :label-width="formLabelWidth">
                    <el-input v-model="form.valid_month" auto-complete="off" readonly placeholder="10"></el-input>
                </el-form-item>
                <el-form-item label="续费日期" :label-width="formLabelWidth">
                    <el-date-picker
                            v-model="form.paid_at"
                            type="date"
                            placeholder="选择缴费日期" format="yyyy 年 MM 月 dd 日" value-format="yyyy-MM-dd">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="功能配置" :label-width="formLabelWidth" style="width: 100%;">
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.func_config.dust">扬尘</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.func_config.pm10">PM10</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.func_config.pm2">PM2.5</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.func_config.point">露点</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.func_config.pressure">气压</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.func_config.humidity">湿度</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.func_config.temperature">温度</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.func_config.noise">噪音</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.func_config.gps">GPS</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.func_config.wind_direction">风向</el-checkbox>
                    <el-checkbox style="width: 200px;margin-left: 30px;" v-model="form.func_config.wind_speed">风速</el-checkbox>
                </el-form-item>
                <el-form-item label="备注" :label-width="formLabelWidth" style="width: 100%;">
                    <el-input
                            type="textarea"
                            :rows="2"
                            placeholder="请输入内容"
                            v-model="form.remark">
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

        <search-box :chose="chose" v-on:dbClickSelection="getUnitValue" v-on:closeSearchBox="closeUnitValue" :requestName="requestName" :currentUnitModel="currentUnitModel"></search-box>
    </div>
</template>

<script>
    import SearchBox from '../../components/SearchBox.vue'
    import {getdust, editdust, updatedust, destroydust, storedust} from '../../api/dust'
    import {pagesize, perPagesize} from '../../config/common'
    import {implode} from "../../utils/common";

    export default {
        components: {
            SearchBox
        },
        data() {
            return {
                query: {
                    is_online: ''
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
                form: {
                    id: '',
                    item_id: '',
                    right_id: '',
                    install_id: '',
                    is_monitor: '',
                    monitor_place_name: '',
                    sn: '',
                    d_model: '',
                    installed_at: '',
                    disassembled_at: '',
                    SIM_card: '',
                    valid_month: '',
                    paid_at: '',
                    func_config: {
                        dust: '',
                        pm10: '',
                        pm2: '',
                        point: '',
                        pressure: '',
                        humidity: '',
                        temperature: '',
                        noise: '',
                        gps: '',
                        wind_direction: '',
                        wind_speed: ''
                    },
                    remark: '',
                },
                formLabelW: '100px',
                tableData: [],
                dustAdd: false,
                formLabelWidth: '120px',
                dialogImageUrl: '',
                Monitoring: false,
                submitType: '',
                currentPage: 1, //当前页数
                pagesize: pagesize,
                perPagesize: perPagesize,
                total: null,
                loading: true,
                items: [{label: '请选择所在项目',value: 0}],
                units: [{label: '请选择所在单位',value: 0}],
                chose: false,
                requestName: '',
                currentUnitModel: "",
            }
        },
        created() {
            this.$router.replace({path: this.$route.path, query: {page: this.currentPage}})
            this.getTableData()
        },
        methods: {
            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePictureCardPreview(file) {
                this.Monitoring = file.url;
                this.Monitoring = true;
            },
            handleAdd() {
                this.initForm()
                this.dustAdd = true
                this.submitType = 'add'
            },
            handleSelectionChange(selection) {
                this.multipleSelection = implode(selection, 'id')
            },
            handleEdit() {
                this.submitType = 'edit'
                if (this.multipleSelection.length === 1) {
                    this.getEdit(this.multipleSelection[0])
                    this.dustAdd = true
                }
            },
            getEdit(id) {
                editdust(id).then(res => {
                    this.editData = res.data.data
                    this.initForm()
                    let Func_config = JSON.parse(this.editData.func_config) || this.form.func_config
                    this.form.id = this.editData.id
                    this.form.item_id = this.editData.item_id
                    this.form.right_id = this.editData.right_id
                    this.form.install_id = this.editData.install_id
                    this.form.is_monitor = this.editData.is_monitor
                    this.form.monitor_place_name = this.editData.monitor_place_name
                    this.form.sn = this.editData.sn
                    this.form.d_model = this.editData.d_model
                    this.form.installed_at = this.editData.installed_at
                    this.form.disassembled_at = this.editData.disassembled_at
                    this.form.SIM_card = this.editData.SIM_card
                    this.form.valid_month = this.editData.valid_month
                    this.form.paid_at = this.editData.paid_at
                    this.form.func_config.dust = Func_config.dust
                    this.form.func_config.pm10 = Func_config.pm10
                    this.form.func_config.pm2 = Func_config.pm2
                    this.form.func_config.point = Func_config.point
                    this.form.func_config.pressure = Func_config.pressure
                    this.form.func_config.humidity = Func_config.humidity
                    this.form.func_config.temperature = Func_config.temperature
                    this.form.func_config.noise = Func_config.noise
                    this.form.func_config.gps = Func_config.gps
                    this.form.func_config.wind_direction = Func_config.wind_direction
                    this.form.func_config.wind_speed = Func_config.wind_speed
                    this.form.remark = this.editData.remark
                })
            },
            handleDelete() {
                this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    destroydust({id: this.multipleSelection}, this.page, this.pagesize).then(res => {
                        if (res.data.response_status === 'success') {
                            this.tableData = res.data.data.data
                            this.$message({
                                type: 'success',
                                showClose: true,
                                message: res.data.msg
                            })
                        }
                    })
                }).catch(() => {
                    return
                })
            },
            search() {
                this.getTableData(this.query)
            },
            confirm() {
                let data = this.form
                data.id = parseInt(data.id)
                data.item_id = parseInt(data.item_id)
                data.right_id = parseInt(data.right_id)
                data.install_id = parseInt(data.install_id)
                data.is_monitor = parseInt(data.is_monitor)
                data.valid_month = parseInt(data.valid_month)
                data.func_config = JSON.stringify(data.func_config)
                console.log(data.func_config)

                if (this.submitType === 'edit') {
                    updatedust(this.editData.id, data, this.currentPage, this.pagesize).then(res => {
                        this.tableData = res.data.data.data
                        this.dustAdd = false
                        this.$message({
                            type: 'success',
                            showClose: true,
                            message: res.data.msg
                        })
                    })
                } else {
                    storedust(data, this.pagesize).then(res => {
                        if (res.data.response_status === 'success') {
                            this.tableData = res.data.data.data
                            this.dustAdd = false
                            this.$message({
                                type: 'success',
                                showClose: true,
                                message: res.data.msg
                            })
                        }
                    })
                }
            },
            getTableData(data = {}) {
                getdust(this.currentPage, data, this.pagesize).then(res => {
                    if (res.data.response_status === "success") {
                        this.tableData = res.data.data.data
                        this.total = res.data.data.total
                        this.loading = false
                    }
                })
            },
            handleSizeChange() {

            },
            handleCurrentChange() {

            },
            searchUnitBox(requestName, currentUnitModel) {
                this.chose = true
                this.requestName = requestName
                this.currentUnitModel = currentUnitModel
            },
            getUnitValue(row) {
                this.chose = false
                if (this.requestName === 'item') {
                    this.$set(this.items, 0, {label: row.name, value: row.id})
                    this.$set(this.form, 'item_id', row.id)
                } else {
                    this.$set(this.units, 0, {label: row.name, value: row.id})
                    this.form[this.currentUnitModel] = row.name
                }
            },
            closeUnitValue() {
                this.chose = false
            },
            cellClick(row) {
                this.$refs.table.toggleRowSelection(row, true)
            },
            dblclick(row) {
                this.submitType = 'edit'
                this.$refs.table.clearSelection()
                this.$refs.table.toggleRowSelection(row, true)
                editdust(row.id).then(res => {
                    this.editData = res.data.data
                    this.getEdit(row.id)
                    this.dustAdd = true
                })
            },
            initForm() {
                this.form = {
                    item_id: 0,
                    right_id: 0,
                    install_id: 0,
                    is_monitor: 1,
                    monitor_place_name: '',
                    sn: '',
                    d_model: '',
                    installed_at: '',
                    disassembled_at: '',
                    SIM_card: '',
                    valid_month: 10,
                    paid_at: '',
                    func_config: {
                        dust: '',
                        pm10: '',
                        pm2: '',
                        point: '',
                        pressure: '',
                        humidity: '',
                        temperature: '',
                        noise: '',
                        gps: '',
                        wind_direction: '',
                        wind_speed: ''
                    },
                    remark: '',
                }
            },
            beforeRouteUpdate(to, from, next) {
                console.log(to,from)
                const newId = to.query.sn;
                const oldId = from.query.page;
                console.log(newId,oldId);    //345,123
                next();
            }
        },

    }
</script>

<style>
    .dust-form .el-form-item {
        width: 30%;
        float: left;
        padding-right: 60px;
    }
</style>