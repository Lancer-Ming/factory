<template>
    <div class="container dust-vedio">
        <el-row style="margin-top: 20px;">
            <el-form :model="form" size="mini">
                <el-form-item label="监测点名称" :label-width="formLabelW">
                    <el-input v-model="form.item_name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="施工单位" :label-width="formLabelW">
                    <el-input v-model="form.unit_name" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="SN" :label-width="formLabelW">
                    <el-input v-model="form.sn" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="是否在线" :label-width="formLabelW">
                    <el-select v-model="form.is_online" placeholder="请选择活动区域">
                        <el-option label="有在线设备" value="1"></el-option>
                        <el-option label="无在线设备" value="0"></el-option>
                        <el-option label="全部" value=""></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="有无报警" :label-width="formLabelW">
                    <el-select v-model="form.cur_warn_count" placeholder="请选择活动区域">
                        <el-option label="有报警设备" value="1"></el-option>
                        <el-option label="无报警设备" value="0"></el-option>
                    </el-select>
                </el-form-item>
                <el-button type="primary" plain size="mini" style="float: left" @click="search">查询</el-button>
                <el-button size="mini" style="float: left" @click="reset">清空</el-button>
                <el-button type="warning" icon="el-icon-star-off" circle plain style="float: right;margin-right: 15px" @click="unregistered=true"></el-button>
            </el-form>
        </el-row>
        <el-row>
            <el-table
                    :data="tableData"
                    border
                    stripe
            >
                <el-table-column type="expand" prop="dusts">
                    <template slot-scope="scope">
                        <el-form label-position="left" inline class="demo-table-expand">
                            <el-table :data="scope.row.dusts">
                                <el-table-column label="SN" align="center" prop="sn" width="100">
                                </el-table-column>
                                <el-table-column label="备案编号" align="center" prop="pre_warn_count" width="100">
                                </el-table-column>
                                <el-table-column label="项目编号" align="center" prop="cur_warn_count" width="100">
                                </el-table-column>
                                <el-table-column label="机械类型" align="center" width="100">
                                    <template slot-scope="scope">
                                        <span>扬尘噪音</span>
                                    </template>
                                </el-table-column>
                                <el-table-column label="状态" align="center" width="100">
                                    <template slot-scope="scope">
                                        <span>{{ scope.row.is_online ? '在线' : '离线'}}</span>
                                    </template>
                                </el-table-column>
                                <el-table-column label="查看" align="center" prop="look" width="500">
                                    <template slot-scope="scope">
                                        <el-button size="mini" type="primary" plain class="dvedio_btn" @click="addTab('/video/dust/workingdata', '运行数据', scope.row.sn)">运行数据</el-button>
                                        <el-button size="mini" type="danger" plain class="dvedio_btn" @click="addTab('/video/dust/Information', '报警信息', scope.row.sn)">报警信息</el-button>
                                        <el-button size="mini" type="warning" plain class="dvedio_btn" @click="addTab('/video/dust/Running', '运行时间', scope.row.sn)">运行时间</el-button>
                                        <el-button size="mini" type="primary" plain class="dvedio_btn" @click="addTab('/video/dust/Chart', '图表', scope.row.sn)">图表</el-button>
                                        <el-button size="mini" type="success" plain class="dvedio_btn" @click="addTab('/video/dust/Standard', '设定标准值', scope.row.sn)">设定标准值</el-button>
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
                        width="500"
                        align="center"
                >
                </el-table-column>
                <el-table-column
                        prop="b_unit"
                        label="施工单位"
                        width="300"
                        align="center"
                >
                </el-table-column>
                <el-table-column
                        prop="tower_crane"
                        label="扬尘"
                        width="650"
                        align="center"
                >
                    <el-table-column
                            label="总计"
                            width="100"
                            align="center"
                    >
                        <template slot-scope="scope">
                            <span>{{ scope.row.dusts.length}}</span>
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="在线"
                            width="100"
                            align="center"
                    >
                        <template slot-scope="scope">
                            <span>{{ scope.row.online_count }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column
                            prop="offline_count"
                            label="离线"
                            width="100"
                            align="center"
                    >
                        <template slot-scope="scope">
                            <span>{{ scope.row.offline_count = (scope.row.dusts.length) - (scope.row.online_count) }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column
                            prop="pre_warning_count"
                            label="预警"
                            width="100"
                            align="center"
                    >
                    </el-table-column>
                    <el-table-column
                            prop="is_warning_count"
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

        <el-dialog title="未登记SN" :visible.sync="unregistered" width="30%" center>
            <el-table :data="gridData" border style="margin:10px 0px 30px;">
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
                <el-table-column property="sn" label="SN" width="200" align="center"></el-table-column>
                <el-table-column align="center">
                    <template slot-scope="scope">
                        <el-button type="primary" plain size="mini" @click="register">去登记</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </el-dialog>
    </div>
</template>


<script>
    import {pagesize, perPagesize} from '../../config/common'
    import {Local} from '../../utils/common'
    import {getcontrol} from '../../api/dustControl'

    export default {
        data() {
            return {
                form: {
                    item_name: '',
                    unit_name: '',
                    sn: '',
                    is_online: '',
                    cur_warn_count: '',
                },
                formLabelW: "120px",
                tableData: [],
                currentPage: 1, //当前页数
                pagesize: pagesize,
                perPagesize: perPagesize,
                total: null,
                distribution: false,
                gridData: [{
                    sn: '121212'
                }],
                unregistered: false
            }
        },
        created() {
            this.$router.replace({path: this.$route.path, query: {page: this.currentPage}})
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


            addTab(path, title, sn) {
                let name = path.split('/').join('.').substr(1)
                let isRepeat = false
                let tabs = this.$root.$data.tabs
                tabs.forEach((item, index) => {
                    if (item.name === name) {
                        isRepeat = true
                    }
                })

                // 如果是tabs里没有
                if (!isRepeat) {
                    tabs.push({
                        title,
                        name,
                        path: path,
                        is_sub: true,
                        query: {sn}
                    })

                    new Local().set('tabs', tabs)
                }

                new Local().set('activeTabs', name)

                this.$root.$data.tabsValue = name


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
            },
            getTableData(data = {}) {
                getcontrol(this.currentPage, data, this.pagesize).then(res => {
                    if (res.data.response_status === "success") {
                        console.log(res)
                        this.tableData = res.data.data.items
                        this.total = res.data.data.total
                        this.loading = false
                    }
                })
            },
            search() {
                this.getTableData(this.form)
            },
            reset() {
                for (var item in this.form) {
                    this.$set(this.form, item, '')
                }
                this.getTableData(this.form)
            },
            register(){
                return
                this.$router.replace({path: '/device/dust/index', query: {sn: '1111'}})
            }
        }

    }
</script>
<style>
    .dust-vedio .el-form-item {
        width: 25%;
        float: left;
        padding-right: 60px;
    }

    .dvedio_btn {
        margin: 10px 0px;
    }
</style>

