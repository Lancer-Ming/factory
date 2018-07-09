<template>
    <div class="container">
        <el-row style="padding: 10px;">
            <el-button
                    size="mini"
                    type="primary"
                    @click="handleAdd">新增
            </el-button>
            <el-button
                    size="mini"
                    type="danger"
                    @click="handleDeleteSeleted">删除
            </el-button>
        </el-row>
        <el-table
                :data="tableData"
                align
                border
                @selection-change="handleSelectionChange"
                style="width: 100%">

            <el-table-column
                    type="selection"
                    width="55">
            </el-table-column>
            <el-table-column
                    label="编号"
                    align="center"
                    width="100">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.id }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="用户名"
                    align="center"
                    width="100">
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ scope.row.username }}</el-tag>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="真实姓名"
                    align="center"
                    width="100">
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ scope.row.realname }}</el-tag>
                    </div>
                </template>
            </el-table-column>
           
            <el-table-column
                    label="所属用户组"
                    align="center"
                    width="300">
                <template slot-scope="scope">
                    <el-tag size="medium">{{ implode(scope.row.roles, 'name').join(',') }}</el-tag>
                </template>
            </el-table-column>

            <el-table-column
                    label="邮箱"
                    align="center"
                    width="200">
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ scope.row.email }}</el-tag>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="创建时间"
                    align="center"
                    width="300">
                <template slot-scope="scope">
                    <i class="el-icon-time"></i> <span style="margin-left: 10px">{{ scope.row.created_at }}</span>
                </template>
            </el-table-column>

            <el-table-column label="操作" align="center" width="400">
                <template slot-scope="scope">
                    <el-button
                            size="mini"
                            type="info"
                            @click="handleEdit(scope.$index, scope.row)">编辑
                    </el-button>
                    <el-button
                            size="mini"
                            type="danger"
                            @click="handleDelete(scope.$index, scope.row)">删除
                    </el-button>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog title="用户信息" :visible.sync="showForm" width="22%">
            <el-form :model="form">
                <el-form-item label="用户名" :label-width="formLabelWidth">
                    <el-input v-model="form.username" auto-complete="off" style="width:200px;" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="真实姓名" :label-width="formLabelWidth">
                    <el-input v-model="form.realname" auto-complete="off" style="width:200px;" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="邮箱" :label-width="formLabelWidth">
                    <el-input v-model="form.email" auto-complete="off" style="width:250px;" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="密码" :label-width="formLabelWidth">
                    <el-input type="password" v-model="form.password" auto-complete="off" style="width:200px;" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="所属用户组" :label-width="formLabelWidth">
                    <el-select v-model="form.role_id" multiple filterable placeholder="请选择" value-key="item">
                        <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
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
    import {getUsers, getRoles, updateUser, addUser, destroyUser} from "../api/user.js";
    import {implode} from "../utils/common.js";
    export default {
        data() {
            return {
                tableData: [],
                showForm: false,
                formType: '',
                form: {
                    username: "",
                    realname: "",
                    sex: 1,
                    password: "",
                    role_id: [],
                    email: ""
                },
                formLabelWidth: "100px",
                options: [],
                no: '',
                currentPage: 1,
                multipleSelection: []
            };
        },
        created() {
            getUsers(this.currentPage).then(res => {
                this.tableData = res.data.data.data;
            }),
                getRoles().then(res => {
                    if (res.data.response_status === "success") {
                        this.options = res.data.data;
                    }
                })
        },
        methods: {
            handleEdit(index, row) {
                // 给表单赋值
                this.formType = 'edit'
                this.form = {
                    username: row.username,
                    realname: row.realname,
                    sex: row.sex,
                    password: "",
                    email: row.email
                };
                this.$set(this.form, 'role_id', implode(row.roles, 'id'))
                this.showForm = true;
                this.no = row.id
            },
            handleAdd() {
                // 重新初始化表单
                this.formType = 'add'
                this.form = {
                    username: "",
                    realname: "",
                    sex: 1,
                    password: "",
                    role_id: [],
                    email: ""
                };
                this.showForm = true;
            },
            handleDelete(index, row) {
                this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    destroyUser(row.id, this.currentPage).then(res => {
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
            handleDeleteSeleted() {
                this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    destroyUser(this.multipleSelection, this.currentPage).then(res => {
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
            submitForm() {
                if (this.formType === 'edit') {
                    updateUser(this.no, this.form).then(res => {
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
                    addUser(this.form).then(res => {
                        if (res.data.response_status === 'success') {
                            this.tableData = res.data.data.data
                            this.$message({
                                type: 'success',
                                showClose: true,
                                message: res.data.msg
                            })
                        }
                        this.showForm = false
                    })
                }

            },
            handleSelectionChange(val) {
                this.multipleSelection = implode(val, 'id')
            },
            implode(arr, attr) {
                return implode(arr, attr);
            },

        },
    };
</script>

<style scoped>
    .el-form-item {
        margin-bottom: 0px;
    }
</style>
