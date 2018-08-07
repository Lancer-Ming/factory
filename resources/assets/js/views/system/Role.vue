<template>
    <div class="container Role-page">
        <div class="toolsbar">
        <el-row class="btnBox">
            <el-button
                    size="mini"
                    type="primary"
                    @click="handleAdd">新增</el-button>
            <el-button
                    size="mini"
                    type="danger"
                    @click="handleDeleteSeleted">删除</el-button>
        </el-row>
        </div>
        <!--<div class="searchBox">-->
        <!--</div>-->
        <el-table
                :data="tableData"
                align
                border
                stripe
                style="width: 100%"
                size="mini"
                :default-sort = "{prop: 'id', order: 'ascending'}"
                @selection-change="handleSelectionChange"
        >
            <!--v-loading="loading"-->

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
                    type="selection"
                    align="center"
                  >
            </el-table-column>
            <el-table-column
                    label="用户组名"
                    align="center"
                   >
                <template slot-scope="scope">
                    <el-tag size="medium">{{ scope.row.name }}</el-tag>
                </template>
            </el-table-column>

            <el-table-column
                    label="更新时间"
                    align="center"
                    >
                <template slot-scope="scope">
                    <i class="el-icon-time"></i>
                    <span>{{ scope.row.created_at }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="创建时间"
                    align="center"
            >
                <template slot-scope="scope">
                    <i class="el-icon-time"></i>
                    <span>{{ scope.row.created_at }}</span>
                </template>
            </el-table-column>
            <el-table-column label="操作" align="center" width="500">
                <template slot-scope="scope">
                    <el-button
                            size="mini"
                            type="primary"
                            @click="handleEdit(scope.$index, scope.row)">编辑
                    </el-button>
                    <el-button
                            size="mini"
                            type="primary"
                            plain
                            @click="handleEditPermission(scope.$index, scope.row)">权限设置
                    </el-button>
                    <el-button
                            size="mini"
                            type="danger"
                            @click="handleDelete(scope.$index, scope.row)">删除
                    </el-button>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog title="用户组" :visible.sync="showForm" width="22%">
            <el-form :model="form">
                <el-form-item label="用户组名" :label-width="formLabelWidth">
                    <el-input v-model="form.name" auto-complete="off" style="width:200px;" size="mini"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="showForm = false">取 消</el-button>
                <el-button type="primary" @click="submitForm">确 定</el-button>
            </div>
        </el-dialog>

    </div>
</template>

<script>
    import {  getRoles, updateRole, storeRole, destroyRole } from "../../api/role.js";
    import {implode} from "../../utils/common.js";
    export default {
        data() {
            return {
                tableData: [],
                showForm: false,
                //loading: true,
                formType: '',
                form: {
                    name
                },
                formLabelWidth: "100px",
                options: [],
                no: '',
                multipleSelection: [],
                page: ''
            };
        },
        created() {
            getRoles().then(res => {
                if (res.data.response_status === "success") {
                        this.tableData = res.data.data.data
                        loading: false
                }
            })
        },
        methods: {
            handleEdit(index, row) {
                this.form = {
                   name: row.name
                };
                this.$set(this.form, 'name', row.name)
                this.showForm = true;
                this.no = row.id
                this.formType = 'edit'
            },
            handleAdd(index, row) {
                // 重新初始化表单
                this.form.name = ''
                this.showForm = true;
                this.formType = 'add'
            },
            handleDelete(index, row) {
                this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    destroyRole(row.id, this.page).then(res => {
                        console.log(res)
                        if (res.data.response_status === "success") {
                            this.tableData = res.data.data.data
                            this.$message({
                                type: 'success',
                                showClose: true,
                                message: res.data.msg
                            })
                        }
                    })
                }).catch(() => {
                    return
                })
            },
            handleDeleteSeleted() {
                this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    destroyRole(this.multipleSelection, this.page).then(res => {
                        if (res.data.response_status === "success") {
                            // 改变tableData
                            this.tableData = res.data.data.data
                            this.$message({
                                type: 'success',
                                showClose: true,
                                message: res.data.msg
                            })
                        }
                    })
                }).catch(() => {
                    return
                })
            },
            handleEditPermission(index, row) {
                this.$router.push({path: `/system/role/${row.id}/edit_permission`})
            },
            submitForm() {
                if (this.formType === 'edit') {
                    updateRole(this.no, this.form.name).then(res => {
                        this.showForm = false
                        this.$message({
                            type: 'success',
                            showClose: true,
                            message: res.data.msg
                        })
                        this.tableData.forEach((elem, index) => {
                            if (elem.id == this.no) {
                                this.$set(this.tableData, index, res.data.data)
                            }
                        })
                    })
                } else {
                    storeRole(this.form.name).then(res => {
                        if (res.data.response_status === "success") {
                            this.tableData = res.data.data.data
                            this.showForm = false
                            this.$message({
                                type: 'success',
                                showClose: true,
                                message: res.data.msg
                            })
                        }
                    })
                }
            },
             handleSelectionChange(val) {
                this.multipleSelection = implode(val, 'id')
            },
            implode(arr, attr) {
                return implode(arr, attr);
            }
        },
    };
</script>

<style scoped>
    .el-form-item {
        margin-bottom: 0px;
    }
</style>
