<template>
    <div class="container content-container manager-page">
        <div class="toolsbar">
            <div class="toolsbar">
                <el-row class="btnBox">
                    <el-button
                            size="mini"
                            type="primary"
                            icon="el-icon-plus"
                            @click="handleAdd">新增
                    </el-button>
                    <el-button
                            size="mini"
                            type="primary"
                            plain
                            icon="el-icon-edit"
                            @click="handleEdit">编辑
                    </el-button>
                    <el-button
                            size="mini"
                            type="danger"
                            icon="el-icon-delete"
                            @click="handleDeleteSeleted">删除
                    </el-button>
                    <el-button
                            size="mini"
                            icon="el-icon-sort"
                            @click="importData">导入
                    </el-button>
                    <el-button
                            size="mini"
                            icon="el-icon-download"
                            @click="downloadTmp">模板下载
                    </el-button>
                    <el-button
                            size="mini"
                            icon="el-icon-download"
                            @click="exportCurrentData">导出当前数据
                    </el-button>
                    <el-button
                            size="mini"
                            icon="el-icon-download"
                            @click="exportAllData">导出全部数据
                    </el-button>
                </el-row>

            </div>
            <el-table
                    :data="tableData"
                    border
                    stripe
                    size="mini"
                    class="as-table"
            >
                <el-table-column
                        prop="name"
                        label="姓名"

                >
                </el-table-column>
                <el-table-column
                        prop="sex"
                        label="性别"
                >
                </el-table-column>
                <el-table-column
                        prop="card_no"
                        label="身份证号"
                >
                </el-table-column>
                <el-table-column
                        prop="unit"
                        label="所在单位"
                >
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="联系方式"
                >
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="工作区域"
                >
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="备注"
                >
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="申请日期"
                >
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="申请人"
                >
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="申请说明"
                >
                </el-table-column>
            </el-table>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tableData:[{
                    name: '王小虎',
                }]
            }
        },
        methods: {
            handleAdd() {
            },
            handleEdit() {
            },
            handleDeleteSeleted() {
            },
            importData() {
            },
            downloadTmp() {
            },
            exportCurrentData() {
            },
            exportAllData() {
            },
        }
    }
</script>