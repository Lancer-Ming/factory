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
            <el-form :model="form">
                <el-form-item label="所在项目" :label-width="formLabelWidth">
                    <el-select v-model="form.item_id" placeholder="请选择所在项目" disabled>
                        <el-option v-for="(item,index) in items" :label="item.label" :key="index" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('item')">...</el-button>
                </el-form-item>
                <el-form-item label="产权单位" :label-width="formLabelWidth">
                    <el-select v-model="form.right_unit_id" placeholder="请选择产权单位" disabled>
                        <el-option label="" value=""></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('unit')">...</el-button>
                </el-form-item>
                <el-form-item label="生产厂商单位" :label-width="formLabelWidth">
                    <el-select v-model="form.produce_unit_id" placeholder="请选择生产产商" disabled>
                        <el-option label="" value=""></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox('unit')">...</el-button>
                </el-form-item>
                <el-form-item label="是否监控" :label-width="formLabelWidth">
                    <el-switch
                            v-model="form.is_monitor"
                    >
                    </el-switch>
                </el-form-item>
                <el-form-item label="司机" :label-width="formLabelWidth">
                    <el-input v-model="form.driver" auto-complete="off"></el-input>
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
                <el-form-item label="塔吊参数" :label-width="formLabelWidth">
                    <el-input v-model="form.parameters" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="出厂日期" :label-width="formLabelWidth">
                    <el-date-picker
                            v-model="form.left_at"
                            type="date"
                            placeholder="选择出厂日期">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="安装单位" :label-width="formLabelWidth">
                    <el-input v-model="form.install_unit_id" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="塔机ID" :label-width="formLabelWidth">
                    <el-input v-model="form.crane_id" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="黑匣子SN" :label-width="formLabelWidth">
                    <el-input v-model="form.sn" auto-complete="off"></el-input>
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
                            placeholder="选择缴费日期">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="安装日期" :label-width="formLabelWidth">
                    <el-date-picker
                            v-model="form.installed_at"
                            type="date"
                            placeholder="选择安装日期">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="功能配置" :label-width="formLabelWidth">
                    <el-checkbox v-model="form.function_config"></el-checkbox>
                </el-form-item>
                <el-form-item label="身份识别" :label-width="formLabelWidth">
                    <el-checkbox v-model="form.identify"></el-checkbox>
                </el-form-item>
                <el-form-item label="高度" :label-width="formLabelWidth">
                    <el-checkbox v-model="form.height"></el-checkbox>
                </el-form-item>
                <el-form-item label="幅度" :label-width="formLabelWidth">
                    <el-checkbox v-model="form.range"></el-checkbox>
                </el-form-item>
                <el-form-item label="回转" :label-width="formLabelWidth">
                    <el-checkbox v-model="form.rotation"></el-checkbox>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button>取 消</el-button>
                <el-button type="primary">确 定</el-button>
            </div>
        </el-dialog>

        <search-box :chose="chose" v-on:dbClickSelection="getUnitValue" v-on:closeSearchBox="closeUnitValue" :requestName="requestName"></search-box>
    </div>
</template>

<script>
    import SearchBox from '../../components/SearchBox.vue'
    export default {
        components:{
            SearchBox
        },
        data() {
            return {
                form:{
                    id: '',
                    item_id: '',
                    right_unit_id: '',
                    produce_unit_id: '',
                    is_monitor: true,
                    driver: '',
                    record_no: '',
                    floor_no: '',
                    c_model: '',
                    left_no: '',
                    parameters: '',
                    left_at: '',
                    install_unit_id: '',
                    crane_id: '',
                    sn: '',
                    GPRS: '',
                    validity_month: '',
                    model:　'',
                    paid_at: '',
                    installed_at: '',
                    function_config: true,
                    identify: true,
                    height: true,
                    range: true,
                    rotation: true
                },
                items: [],
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
            }
        },
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
                this.form = {
                    id: '',
                    item_id: '',
                    right_unit_id: '',
                    produce_unit_id: '',
                    is_monitor: true,
                    driver: '',
                    record_no: '',
                    floor_no: '',
                    c_model: '',
                    left_no: '',
                    parameters: '',
                    left_at: '',
                    install_unit_id: '',
                    crane_id: '',
                    sn: '',
                    GPRS: '',
                    validity_month: '',
                    model:　'',
                    paid_at: '',
                    installed_at: '',
                    function_config: true,
                    identify: true,
                    height: true,
                    range: true,
                    rotation: true
                }
                this.craneAdd = true
                this.submitType = 'add'
            },
            searchUnitBox(requestName) {
                this.chose = true
                this.requestName = requestName
            },
            getUnitValue(row){
                this.chose = false
                this.$set(this.items, 0, {label: row.name, value: row.id})
                this.$set(this.form, 'item_id', row.id)
            },
            closeUnitValue(){
                this.chose = false
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