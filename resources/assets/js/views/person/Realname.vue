<template>
    <div class="container realname">
        <el-row>
            <el-form ref="form" :model="form" label-width="80px" size=mini style="margin-top:20px;">
                <el-form-item label="企业">
                    <el-select v-model="form.enterprise" placeholder="请选择活动区域">
                        <el-option label="区域一" value="shanghai"></el-option>
                        <el-option label="区域二" value="beijing"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="姓名">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="身份证号">
                    <el-input v-model="form.number"></el-input>
                </el-form-item>
                <el-button type="warning" size="mini" class="real-search">搜索</el-button>
            </el-form>
        </el-row>
        <el-row class="real_btn">
            <el-button type="primary" plain size="mini" icon="el-icon-share" @click="statistics=true">统计</el-button>
            <el-button type="warning" plain size="mini" icon="el-icon-sort-down">导出当前数据</el-button>
            <el-button type="danger" plain size="mini" icon="el-icon-sort">导出全部数据</el-button>
        </el-row>
        <el-row>
            <el-table
                    :data="tableData"
                    stripe
                    border
                    center
                    style="width: 100%;margin-top:20px;">
                <el-table-column
                        type="index"
                        width="50"
                        align="center">
                </el-table-column>
                <el-table-column
                        type="selection"
                        width="55"
                        align="center">
                </el-table-column>
                <el-table-column
                        prop="unit"
                        label="所属单位"
                        width="240"
                        align="center">
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="名称"
                        width="80"
                        align="center">
                </el-table-column>
                <el-table-column
                        prop="realname"
                        label="实名制验证"
                        align="center"
                        width="80">
                </el-table-column>
                <el-table-column
                        prop="person"
                        label="人员状态"
                        align="center"
                        width="80">
                </el-table-column>
                <el-table-column
                        prop="number"
                        label="工号"
                        align="center"
                        width="130">
                </el-table-column>
                <el-table-column
                        prop="category"
                        label="人员类别"
                        align="center"
                        width="130">
                </el-table-column>
                <el-table-column
                        prop="tell"
                        label="手机"
                        align="center"
                        width="150">
                </el-table-column>
                <el-table-column
                        prop="nation"
                        label="民族"
                        align="center"
                        width="80">
                </el-table-column>
                <el-table-column
                        prop="native-place"
                        label="籍贯"
                        align="center"
                        width="100">
                </el-table-column>
                <el-table-column
                        prop="date"
                        label="出生日期"
                        align="center"
                        width="130">
                </el-table-column>
                <el-table-column
                        prop="Sex"
                        label="性别"
                        align="center"
                        width="80">
                </el-table-column>
                <el-table-column
                        prop="outlook"
                        label="政治面貌"
                        align="center"
                        width="100">
                </el-table-column>
                <el-table-column
                        prop="education"
                        label="学历"
                        align="center"
                        width="100">
                </el-table-column>
                <el-table-column
                        prop="contract"
                        label="合同编号"
                        align="center"
                        width="130">
                </el-table-column>
                <el-table-column
                        prop="team"
                        label="班组"
                        align="center"
                        width="150">
                </el-table-column>
                <el-table-column
                        prop="training"
                        label="岗前培训"
                        align="center"
                        width="80">
                </el-table-column>
                <el-table-column
                        prop="address"
                        label="地址"
                        align="center"
                        width="300"
                    >
                </el-table-column>
            </el-table>
        </el-row>
        <!--分页-->
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

        <el-dialog title="实名制统计" :visible.sync="statistics" width="70%">
            <el-form :model="form">
                <span class="real-formtit">统计维度:</span>
                <el-radio-group v-model="radio">
                    <el-radio :label="3">参建单位</el-radio>
                    <el-radio :label="6">实名制验证</el-radio>
                    <el-radio :label="9">人员类别</el-radio>
                    <el-radio :label="12">人员状态</el-radio>
                    <el-radio :label="15">工种</el-radio>
                    <el-radio :label="18">班组</el-radio>
                    <el-radio :label="21">年龄</el-radio>
                    <el-radio :label="24">籍贯</el-radio>
                    <el-radio :label="27">民族</el-radio>
                    <el-radio :label="30">学历</el-radio>
                </el-radio-group>
                <pie-chart></pie-chart>
                <bar-chart></bar-chart>
            </el-form>
        </el-dialog>
    </div>
</template>

<script>
    import PieChart from '../../components/PieChart'
    import BarChart from '../../components/BarChart'
    import {pagesize, perPagesize} from '../../config/common'
    export default {
        components: {
            PieChart,
            BarChart
        },
        data() {
            return {
                form: {
                    enterprise: '',
                    name: '',
                    number: ''
                },
                currentPage: 1, //当前页数
                pagesize: pagesize,
                perPagesize: perPagesize,
                total: null,
                tableData: [{
                    unit: '广东德实控股有限公司',
                    name: 'lin',
                    address: '上海市普陀区金沙江路 1518 '
                }, {
                    date: '2016-05-04',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1517 '
                }, {
                    date: '2016-05-01',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1519 '
                }, {
                    date: '2016-05-03',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1516 '
                }],
                statistics: false,
                radio: 3,
            }
        },
        methods:{
            handleSizeChange(pagesize) {
                this.pagesize = pagesize
            },
            handleCurrentChange(currentPage) {
                this.currentPage = currentPage
                this.$router.replace({path: this.$route.path, query: {page: this.currentPage}})
            },

        }
    }
</script>

<style>
    .realname .el-form-item {
        width: 25%;
        float: left;
        padding-right: 10px;
    }

    .realname .real-search {
        float: right;
        margin-right: 3%;
    }

    .real_btn .el-button {
        margin-left: 20px;
    }
    .real-formtit{
        display: inline-block;
        margin-right: 10px;
    }
</style>

