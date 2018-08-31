<template>
    <div class="container Running">
        <el-form ref="form" :model="form" label-width="120px" style="margin-top: 20px;">
            <el-form-item label="时间" size="mini">
                <el-date-picker
                        v-model="form.date"
                        type="date"
                        placeholder="选择日期">
                </el-date-picker>
            </el-form-item>
            <el-form-item>
                <el-button type="warning" plain size="mini">查询</el-button>
                <el-button type="warning" plain size="mini">清空</el-button>
            </el-form-item>
        </el-form>

        <el-table
                :data="tableData"
                border
                style="width: 100%">
            <el-table-column
                    prop="id"
                    align="center"
                    width="60"
                    fixed
                    sortable
                    label="#"
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
                    prop="name"
                    label="监控点名称"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="start_time"
                    label="开始时间"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="end_time"
                    label="结束时间"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="runtime"
                    label="运行时长"
                    width="180"
                    align="center"
            >
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
                    date: ''
                },
                tableData: [],
                currentPage: 1, //当前页数
                pagesize: pagesize,
                perPagesize: perPagesize,
                total: null,
                distribution: false,
            }
        },
        created() {
            this.getTabledata()
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
            getTabledata() {
                getrunning(this.currentPage,  this.$route.query.sn, this.pagesize).then(res => {
                    console.log(res)
                })
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