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
                    <el-input  auto-complete="off"></el-input>
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
                <el-form-item label="备案编号" :label-width="formLabelWidth">
                    <el-input v-model="form.number" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="所在项目" :label-width="formLabelWidth">
                    <el-select v-model="form.region" placeholder="请选择活动区域">
                        <el-option label="区域一" value="shanghai"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="楼号" :label-width="formLabelWidth">
                    <el-input auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="产权单位" :label-width="formLabelWidth">
                    <el-input auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="塔吊出产日期" :label-width="formLabelWidth">
                    <el-input auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="塔吊型号" :label-width="formLabelWidth">
                    <el-input auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="塔吊生产日期" :label-width="formLabelWidth">
                    <el-input auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="塔吊生产厂商" :label-width="formLabelWidth">
                    <el-input auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="塔吊出产编号" :label-width="formLabelWidth">
                    <el-input auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="是否监控" :label-width="formLabelWidth">
                    <el-switch
                            v-model="value"
                    >
                    </el-switch>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button>取 消</el-button>
                <el-button type="primary">确 定</el-button>
            </div>
        </el-dialog>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                form:{
                    name: ''
                },
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
                value: true,
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
                    name: ''
                }
                this.craneAdd = true
                this.submitType = 'add'
            }

        },
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