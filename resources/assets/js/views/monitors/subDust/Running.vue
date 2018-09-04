<template>
    <div class="container Running">
        <el-form ref="form" :model="form" label-width="120px" style="margin-top: 20px;">
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
            <el-form-item>
                <el-button type="warning" plain size="mini" @click="search">查询</el-button>
                <el-button type="warning" plain size="mini">清空</el-button>
            </el-form-item>
        </el-form>

        <el-table
                :data="tableData"
                border
                style="width: 100%">
            <el-table-column
                    type="index"
                    width="50"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="sn"
                    label="SN"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="dust.monitor_place_name"
                    label="监控点名称"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    label="开始时间"
                    width="180"
                    align="center"
            >
                <template slot-scope="scope">
                    <span>{{ scope.row.created_at }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="结束时间"
                    width="180"
                    align="center"
            >
                <template slot-scope="scope">
                    <span>{{ scope.row.updated_at }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    prop="runtime"
                    label="运行时长"
                    width="180"
                    align="center"
            >
                <template slot-scope="scope">
                    <span>{{ scope.row.runtime = parseInt((Date.parse(scope.row.updated_at) - Date.parse(scope.row.created_at))/1000/3600)+"小时"+parseInt((Date.parse(scope.row.updated_at) - Date.parse(scope.row.created_at))/1000/3600/60)+"分钟" }}</span>
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
    import {getrunning} from '../../../api/running'
    import {pagesize, perPagesize} from '../../../config/common'

    export default {
        data() {
            return {
                form: {
                    time: ''
                },
                tableData: [],
                data: [],
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
        created() {
            this.getTableData()
        },
        methods: {
            handleSizeChange(val) {
                console.log(`每页 ${val} 条`);
            },
            handleCurrentChange(val) {
                console.log(`当前页: ${val}`);
            },
            handleCrane() {
                this.distribution = true
            },
            getTableData(time) {
                console.log(time)
                getrunning(this.currentPage, this.$route.query.sn, this.pagesize, time).then(res => {
                    if (res.data.response_status === "success") {
                        console.log(res)
                        this.tableData = res.data.data.data
                        console.log(this.tableData)
                        this.total = res.data.data.total
                    }
                })
            },
            search(){
                let time = this.form.time instanceof Array ? this.form.time.join(',') : this.form.time
                this.getTableData(time)
            }
        }
    }
</script>

<style>
    .Running .el-form-item {
        width: 25%;
        float: left;
    }
</style>