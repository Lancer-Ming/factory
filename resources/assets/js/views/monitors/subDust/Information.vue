<template>
    <div class="container Information">
        <el-form ref="form" :model="form" label-width="120px" style="margin-top: 20px;width: 80%;">
            <el-form-item label="时间" size="mini">
                <el-date-picker
                        v-model="form.time"
                        type="date"
                        placeholder="选择日期">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="报警类型" size="mini">
                <el-select v-model="form.warning_type" placeholder="报警类型">
                    <el-option v-for="(item,index) in alarm_type" :label="item.name" :key='index' :value="item.id"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="预警状态" size="mini" style="width: 32%">
                <el-select v-model="form.warning_status" placeholder="请选择活动区域">
                    <el-option label="全部" value="whole"></el-option>
                    <el-option label="预警" value="warning"></el-option>
                    <el-option label="报警" value="danger"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label=""  size="mini" style="width: 10%;">
                <el-checkbox  name="type"></el-checkbox>
            </el-form-item>
            <el-form-item label="开启自动查询" size="mini" style="width: 20%;">
            </el-form-item>
            <el-form-item size="mini">
                <el-button type="danger" plain size="mini" @click="search">查询</el-button>
            </el-form-item>
        </el-form>

        <el-table
                :data="tableData"
                border
                style="width: 100%"
        >
            <el-table-column
                    type="index"
                    width="50"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="sn"
                    label="SN"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="dust.monitor_place_name"
                    label="监控点名称"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="received_at"
                    label="时间"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column label="扬尘" align="center">
                <el-table-column
                        prop="a34001_Rtd"
                        label="(ug/m³)"
                        width="100"
                        align="center"
                >
                </el-table-column>
            </el-table-column>
            <el-table-column label="PM10" align="center">
                <el-table-column
                        prop="a34002_Rtd"
                        label="(ug/m³)"
                        width="100"
                        align="center"
                >
                </el-table-column>
            </el-table-column>
            <el-table-column label="PM2.5" align="center">
                <el-table-column
                        prop="a34004_Rtd"
                        label="(ug/m³)"
                        width="100"
                        align="center"
                >
                </el-table-column>
            </el-table-column>
            <el-table-column
                    prop="LA_Rtd"
                    label="噪音(dB)"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="a01001_Rtd"
                    label="温度(℃)"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="a01002_Rtd"
                    label="湿度(%)"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="a01006_Rtd"
                    label="气压(mbar)"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="a01007_Rtd"
                    label="风级"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="a01008_Rtd"
                    label="风向"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    label="报警状态"
                    width="300"
                    align="center"
            >
                <template slot-scope="scope">
                    <span style="color: red;">{{ scope.row.errorMsg}}</span>
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
    </div>
</template>

<script>
    import { alarm_type } from "../../../api/json"
    import { getinformation } from "../../../api/information"
    import {pagesize, perPagesize} from '../../../config/common'
    export default{
        data(){
            return{
                form:{
                    time: '',
                    warning_status: '',
                    warning_type: '',
                },
                tableData: [],
                alarm_type: [],
                data: [],
                currentPage: 1, //当前页数
                pagesize: pagesize,
                perPagesize: perPagesize,
                total: null,
                distribution: false,
            }
        },
        created(){
            alarm_type().then(res => {
                this.alarm_type = res.data.alarm_type
            })
            this.getTableData()
        },
        methods:{
            handleSizeChange(val) {
                console.log(`每页 ${val} 条`);
            },
            handleCurrentChange(val) {
                console.log(`当前页: ${val}`);
            },
            handleCrane() {
                this.distribution = true
            },
            getTableData(){
                getinformation(this.currentPage, this.$route.query.sn, this.pagesize).then(res => {
                    if (res.data.response_status === "success") {
                        console.log(res)
                        this.tableData = res.data.data.data
                        console.log(this.tableData)
                        this.total = res.data.total
                    }
                    this.tableData.forEach(function(item,index){
                        item.errorMsg = item.a34001_Rtd_pre_warning ? '扬尘预警': ''
                        item.errorMsg += item.a34001_Rtd_is_warning ? '|扬尘报警' : ''
                        item.errorMsg += item.a34002_Rtd_pre_warning ? '|PM10预警' : ''
                        item.errorMsg += item.a34002_Rtd_is_warning ? '|PM10报警' : ''
                        item.errorMsg += item.a34004_Rtd_pre_warning ? '|PM2.5预警' : ''
                        item.errorMsg += item.a34004_Rtd_is_warning ? '|PM2.5报警' : ''
                        item.errorMsg += item.LA_Rtd_pre_warning ? '|噪音上限预警' : ''
                        item.errorMsg += item.LA_Rtd_is_warning ? '|噪音上限报警' : ''
                        item.errorMsg += item.a01001_Rtd_high_pre_warning ? '|温度上限预警' : ''
                        item.errorMsg += item.a01001_Rtd_high_is_warning ? '|温度上限报警' : ''
                        item.errorMsg += item.a01001_Rtd_low_pre_warning ? '|温度下限预警' : ''
                        item.errorMsg += item.a01001_Rtd_low_is_warning ? '|温度下限报警' : ''
                        item.errorMsg += item.a01002_Rtd_pre_warning ? '|湿度上限预警' : ''
                        item.errorMsg += item.a01002_Rtd_is_warning ? '|湿度上限报警' : ''
                        item.errorMsg += item.a01006_Rtd_high_pre_warning ? '|气压上限预警' : ''
                        item.errorMsg += item.a01006_Rtd_low_pre_warning ? '|气压下限预警' : ''
                        item.errorMsg += item.a01006_Rtd_high_is_warning ? '|气压下限预警' : ''
                        item.errorMsg += item.a01006_Rtd_low_is_warning ? '|气压下限报警' : ''
                        item.errorMsg += item.a01007_Rtd_pre_warning ? '|风速上限预警' : ''
                        item.errorMsg += item.a01007_Rtd_is_warning ? '|风速上限报警' : ''
                    })
                })
            },
            search() {
                this.getTableData(this.form)
            }
        }

    }
</script>
<style>
    .Information .el-form-item{
        width: 35%;
        float: left;
    }
</style>