<template>
    <div class="container dust-vedio">
        <el-row style="margin-top: 20px;">
            <el-form :model="form" size="mini">
                <el-form-item label="项目名称" :label-width="formLabelW">
                    <el-input  auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="产权单位" :label-width="formLabelW">
                    <el-input  auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="备案编号" :label-width="formLabelW">
                    <el-input auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="黑匣子SN" :label-width="formLabelW">
                    <el-input  auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="是否在线" :label-width="formLabelW">
                    <el-select v-model="form.is_online" placeholder="请选择活动区域">
                        <el-option label="有在线设备" value="有在线设备"></el-option>
                        <el-option label="无在线设备" value="无在线设备"></el-option>
                        <el-option label="全部" value="全部"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="是否报警" :label-width="formLabelW">
                    <el-select v-model="form.is_police" placeholder="请选择活动区域">
                        <el-option label="有报警设备" value="有报警设备"></el-option>
                        <el-option label="无报警设备" value="无报警设备"></el-option>
                    </el-select>
                </el-form-item>
                <el-button type="primary" plain size="mini" style="float: left">查询</el-button>
                <el-button size="mini" style="float: left">清空</el-button>
            </el-form>
        </el-row>
        <el-row>
            <el-table
                    :data="tableData"
                    border
                    style="width: 100%"
            >
                <el-table-column type="expand" style="width: 100%;">
                    <template slot-scope="props" style="width: 100%;">
                        <el-form label-position="left" inline class="demo-table-expand">
                            <el-table :data="tableData1" style="width: 100%;">
                                <el-table-column label="SN" align="center" prop="sn" width="100">
                                </el-table-column>
                                <el-table-column label="备案编号" align="center" prop="record_no" width="100">
                                </el-table-column>
                                <el-table-column label="项目编号" align="center" prop="number" width="100">
                                </el-table-column>
                                <el-table-column label="机械类型" align="center" prop="type" width="100">
                                </el-table-column>
                                <el-table-column label="状态" align="center" prop="state" width="100">
                                </el-table-column>
                                <el-table-column label="查看" align="center" prop="look" width="500">
                                    <template slot-scope="scope">
                                        <el-button size="mini" type="primary" plain class="dvedio_btn" @click="addTab(editableTabsValue2)">运行数据</el-button>
                                        <el-button size="mini" type="danger" plain class="dvedio_btn">报警信息</el-button>
                                        <el-button size="mini" type="warning" plain class="dvedio_btn">运行时间</el-button>
                                        <el-button size="mini" type="primary" plain class="dvedio_btn">图表</el-button>
                                        <el-button size="mini" type="success" plain class="dvedio_btn">设定标准值</el-button>
                                    </template>
                                </el-table-column>
                            </el-table>
                        </el-form>
                    </template>
                </el-table-column>
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
                        prop="name"
                        label="监测点名称"
                        width="300"
                        align="center"
                >
                </el-table-column>
                <el-table-column
                        prop="construction_unit"
                        label="施工单位"
                        width="300"
                        align="center"
                >
                </el-table-column>
                <el-table-column
                        prop="tower_crane"
                        label="塔机"
                        width="650"
                        align="center"
                >
                    <el-table-column
                            prop="total"
                            label="总计"
                            width="100"
                            align="center"
                    >
                    </el-table-column>
                    <el-table-column
                            prop="on_line"
                            label="在线"
                            width="100"
                            align="center"
                    >
                    </el-table-column>
                    <el-table-column
                            prop="off_line"
                            label="离线"
                            width="100"
                            align="center"
                    >
                    </el-table-column>
                    <el-table-column
                            prop="warning"
                            label="预警"
                            width="100"
                            align="center"
                    >
                    </el-table-column>
                    <el-table-column
                            prop="call_police"
                            label="报警"
                            width="100"
                            align="center"
                    >
                    </el-table-column>
                </el-table-column>
            </el-table>
        </el-row>
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

        <el-tabs v-model="editableTabsValue2" type="card" closable @tab-remove="removeTab">
            <el-tab-pane
                    v-for="(item, index) in editableTabs2"
                    :key="item.name"
                    :label="item.title"
                    :name="item.name"
            >
                {{item.content}}
            </el-tab-pane>
        </el-tabs>
    </div>
</template>


<script>
    import {pagesize, perPagesize} from '../../config/common'
    export default{
        data(){
            return{
                form:{
                    is_online: '',
                    is_police: '',
                },
                formLabelW: "120px",
                tableData: [{
                    id: '1',
                    name: '中铁隧道集团科技大厦',
                    construction_unit: '中铁隧道集团四处有限公司',
                    tower_crane: '2',
                    total: '2',
                    on_line: '0',
                    off_line: '0',
                    warning: '1',
                    call_police: '1',
                }],
                tableData1: [
                    {
                        sn: '12987122',
                        record_no: '121212',
                        number: '123232',
                        type: '塔机',
                        state: '在线',
                        look: '',
                    }],
                currentPage: 1, //当前页数
                pagesize: pagesize,
                perPagesize: perPagesize,
                total: null,
                distribution: false,



                editableTabsValue2: '2',
                editableTabs2: [{
                    title: 'Tab 1',
                    name: '1',
                    content: 'Tab 1 content'
                }, {
                    title: 'Tab 2',
                    name: '2',
                    content: 'Tab 2 content'
                }],
                tabIndex: 2
            }
        },
        methods:{
            handleSizeChange(val) {
                console.log(`每页 ${val} 条`);
            },
            handleCurrentChange(val) {
                console.log(`当前页: ${val}`);
            },
            handleCrane(){
                this.distribution = true
            },


            addTab(targetName) {
                let newTabName = ++this.tabIndex + '';
                this.editableTabs2.push({
                    title: 'New Tab',
                    name: newTabName,
                    content: 'New Tab content'
                });
                this.editableTabsValue2 = newTabName;
            },
            removeTab(targetName) {
                let tabs = this.editableTabs2;
                let activeName = this.editableTabsValue2;
                if (activeName === targetName) {
                    tabs.forEach((tab, index) => {
                        if (tab.name === targetName) {
                            let nextTab = tabs[index + 1] || tabs[index - 1];
                            if (nextTab) {
                                activeName = nextTab.name;
                            }
                        }
                    });
                }

                this.editableTabsValue2 = activeName;
                this.editableTabs2 = tabs.filter(tab => tab.name !== targetName);
            }
        }

    }
</script>
<style>
    .dust-vedio .el-form-item{
        width: 20%;
        float: left;
        padding-right: 60px;
    }
    .dvedio_btn{
        margin: 10px 0px;
    }
</style>

