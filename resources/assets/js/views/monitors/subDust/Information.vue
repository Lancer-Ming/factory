<template>
    <div class="container Information">
        <el-form ref="form" :model="form" label-width="120px" style="margin-top: 20px;width: 80%;">
            <el-form-item label="时间" size="mini">
                <el-date-picker
                        v-model="form.time"
                        type="daterange"
                        placeholder="选择日期" format="yyyy-MM-dd" value-format="yyyy-MM-dd"
                        unlink-panels
                        range-separator="至"
                        start-placeholder="开始日期"
                        end-placeholder="结束日期"
                        :picker-options="pickerOptions2"
                >
                </el-date-picker>
            </el-form-item>
            <el-form-item label="报警类型" size="mini">
                <el-select v-model="form.warning_type" placeholder="报警类型">
                    <el-option v-for="(item,index) in alarm_type" :label="item.name" :key='index' :value="item.warning_type"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="预警状态" size="mini" style="width: 32%">
                <el-select v-model="form.warning_status" placeholder="请选择活动区域">
                    <el-option v-for="(item,index) in alarm_status" :label="item.name" :key='index' :value="item.warning_status"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label=""  size="mini" style="width: 10%;">
                <el-checkbox  name="type" v-model="autoQuery"></el-checkbox>
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
                v-loading="loading"
        >
            <el-table-column
                    type="index"
                    width="50"
                    align="center"
                    :index="indexMethod"
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
                    <span style="color: #f9bd82;">{{ scope.row.errorMsgPre}}</span>
                </template>
            </el-table-column>
        </el-table>

        <el-row class="paginate">
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-sizes="[30, 60, 90, 120]"
                    :page-size="30"
                    :pager-count="11"
                    layout="total, sizes, prev, pager, next, jumper,slot,->"
                    :total="total">
            </el-pagination>
        </el-row>

    </div>
</template>

<script>
    import { alarm_type,alarm_status } from "../../../api/json"
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
                alarm_status:[],
                IntervalId: '',   //定时器id
                loading:false,
                autoQuery: false,
                currentPage: 1, //当前页数
                pagesize: pagesize,
                perPagesize: perPagesize,
                total: null,
                distribution: false,

                pickerOptions2: {
                    shortcuts: [{
                        text: '最近一周',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近一个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近三个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                            picker.$emit('pick', [start, end]);
                        }
                    }]
                },

            }
        },
        created(){
            alarm_type().then(res => {
                this.alarm_type = res.data.alarm_type
            })
            alarm_status().then(res => {
                this.alarm_status = res.data.alarm_status
            })
            this.getTableData(this.form)
        },
        methods:{
            handleSizeChange(pagesize, sn) {
                this.form.time = this.form.time instanceof Array ? this.form.time.join(',') : this.form.time
                this.pagesize = pagesize
                this.getTableData(this.form)
            },
            handleCurrentChange(currentPage, sn) {
                this.form.time = this.form.time instanceof Array ? this.form.time.join(',') : this.form.time
                this.currentPage = currentPage
                this.$router.replace({
                    path: this.$route.path,
                    query: {page: this.currentPage, sn: this.$route.query.sn}
                })
                this.getTableData(this.form)
            },
            indexMethod(index) {
                return  index + (this.currentPage - 1) * this.pagesize;
            },
            handleCrane() {
                this.distribution = true
            },
            getTableData(data){
                this.loading = true
                getinformation(this.currentPage, this.$route.query.sn, this.pagesize, data).then(res => {
                    if (res.data.response_status === "success") {
                        console.log(res)
                        this.tableData = res.data.data.data
                        this.total = res.data.data.total
                       
                    }
                    this.form.time = this.form.time.split(',')
                    this.tableData.forEach(function(item,index){
                        item.errorMsgPre = item.a34001_Rtd_pre_warning ? '扬尘预警|': ''
                        item.errorMsg = item.a34001_Rtd_is_warning ? '扬尘报警|' : ''
                        item.errorMsgPre += item.a34002_Rtd_pre_warning ? 'PM10预警|' : ''
                        item.errorMsg += item.a34002_Rtd_is_warning ? 'PM10报警|' : ''
                        item.errorMsgPre += item.a34004_Rtd_pre_warning ? 'PM2.5预警|' : ''
                        item.errorMsg += item.a34004_Rtd_is_warning ? 'PM2.5报警|' : ''
                        item.errorMsgPre += item.LA_Rtd_pre_warning ? '噪音上限预警|' : ''
                        item.errorMsg += item.LA_Rtd_is_warning ? '噪音上限报警|' : ''
                        item.errorMsgPre += item.a01001_Rtd_high_pre_warning ? '温度上限预警|' : ''
                        item.errorMsg += item.a01001_Rtd_high_is_warning ? '温度上限报警|' : ''
                        item.errorMsgPre += item.a01001_Rtd_low_pre_warning ? '温度下限预警|' : ''
                        item.errorMsg += item.a01001_Rtd_low_is_warning ? '温度下限报警|' : ''
                        item.errorMsgPre += item.a01002_Rtd_pre_warning ? '湿度上限预警|' : ''
                        item.errorMsg += item.a01002_Rtd_is_warning ? '湿度上限报警|' : ''
                        item.errorMsgPre += item.a01006_Rtd_high_pre_warning ? '气压上限预警|' : ''
                        item.errorMsgPre += item.a01006_Rtd_low_pre_warning ? '气压下限预警|' : ''
                        item.errorMsg += item.a01006_Rtd_high_is_warning ? '气压上限报警|' : ''
                        item.errorMsg += item.a01006_Rtd_low_is_warning ? '气压下限报警|' : ''
                        item.errorMsgPre += item.a01007_Rtd_pre_warning ? '风速上限预警|' : ''
                        item.errorMsg += item.a01007_Rtd_is_warning ? '风速上限报警|' : ''
                        item.errorMsgPre = item.errorMsgPre.substring(0, item.errorMsgPre.length - 1)
                    })
                    
                     this.loading = false
                })
            },
            search() {
                this.form.time = this.form.time instanceof Array ? this.form.time.join(',') : this.form.time
                this.getTableData(this.form)
                
            },
            
        },
        watch:{
            autoQuery(newval,val){
                if(newval){
                   this.IntervalId = setInterval(()=>{this.search()},10000)
                }else{
                    clearInterval(this.IntervalId)
                }
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