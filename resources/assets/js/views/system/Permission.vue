<template>
    <div class="container permission-page">
        <div class="toolsbar">
            <div class="btnBox">
                <el-button type="primary" class="el-icon-plus" @click="handleAdd({id: 0})" style="padding: 5px 8px;">新增顶级菜单</el-button>
            </div>
            <div class="searchBox">
                <el-input
                        placeholder="输入关键字进行过滤"
                        size="mini"
                        style="width: 100%"
                        v-model="filterText">
                </el-input>
            </div>
        </div>
        <el-tree
                :data="treeData"
                node-key="id"
                :expand-on-click-node="false"
                default-expand-all
                highlight-current
                @node-drag-end="handleDragEnd"
                draggable
                class="permission_menu"
                :filter-node-method="filterNode"
                ref="tree2"
        >

            <span class="custom-tree-node" slot-scope="{ node, data }">
            <span>{{ node.label }}</span>
                <span class="permission_buttons">
                    <i class="el-icon-plus" @click="handleAdd(data)" v-if="data.is_category > 0"></i>
                    <i class="el-icon-edit" @click="handleEdit(data)"></i>
                    <i class="el-icon-delete" @click="handleDelete(data)"></i>
                </span>
            </span>
        </el-tree>

        <el-dialog title="编辑菜单权限" :visible.sync="showForm" class="Permission_dialog">
            <el-form :model="form">
                <el-form-item label="上级菜单" :label-width="formLabelWidth">
                    <el-select v-model="form.parent_id" placeholder="请选择" value-key="item" disabled size="mini">
                        <el-option
                                v-for="item in options"
                                :key="item.id"
                                :value="item.id"
                                :label="item.label">
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="权限路由名" :label-width="formLabelWidth">
                    <el-input v-model="form.name" auto-complete="off" size="mini"></el-input>
                </el-form-item>

                <el-form-item label="权限菜单名" :label-width="formLabelWidth">
                    <el-input v-model="form.label" auto-complete="off" size="mini"></el-input>
                </el-form-item>

                <el-form-item label="图标icon" :label-width="formLabelWidth">
                    <el-input v-model="form.icon" auto-complete="off" size="mini"></el-input>
                </el-form-item>

                <el-form-item label="是否为菜单" :label-width="formLabelWidth" class="formLabelWidth_full">
                    <el-radio v-model="form.is_category" :label="1">是</el-radio>
                    <el-radio v-model="form.is_category" :label="0">否</el-radio>
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
    import {
        getPermissions,
        editPermissions,
        updatePermissions,
        addPermissions,
        deletePermissions,
        sortPermissions
    } from '../../api/permission'

    export default {
        watch: {
            filterText(val) {
                this.$refs.tree2.filter(val);
            }
        },
        data() {
            return {
                filterText: '',
                treeData: [],
                options: [],
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },
                form: {
                    parent_id: null,
                    name: '',
                    label: '',
                    icon: '',
                    is_category: 1
                },
                formLabelWidth: "100px",
                formType: '',
                showForm: false,
                id: null
            };
        },
        created() {
            getPermissions().then(res => {
                if (res.data.response_status === "success") {
                    this.treeData = res.data.data.permissions
                    this.options = res.data.data.simplePermissions
                }
            })
        },
        methods: {
            filterNode(value, data) {
                if (!value) return true;
                return data.label.indexOf(value) !== -1;
            },
            submitForm() {
                if (this.formType === 'edit') {
                    updatePermissions(this.id, this.form).then(res => {
                        this.successCallback(res)
                    })
                } else {
                    addPermissions(this.form).then(res => {
                        this.successCallback(res)
                    })
                }
            },

            handleEdit(data) {
                this.formType = 'edit'
                editPermissions(data.id).then(res => {
                    if (res.data.response_status === "success") {
                        let editData = res.data.data
                        this.form = {
                            name: editData.name,
                            label: editData.label,
                            icon: editData.icon,
                            is_category: editData.is_category
                        }
                        this.$set(this.form, 'parent_id', editData.parent_id)
                        this.id = editData.id
                        this.showForm = true
                    }
                })
            },
            handleAdd(data) {
                // 改变表单类型
                this.formType = 'add'
                // 清空form
                this.form = {
                    parent_id: null,
                    name: '',
                    label: '',
                    icon: '',
                    is_category: 1
                }
                // 改变表单的上级菜单
                this.$set(this.form, 'parent_id', data.id)
                // 使表单显示
                this.showForm = true
            },
            handleDelete(data) {
                this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    deletePermissions(data.id).then(res => {
                        this.successCallback(res)
                    })
                }).catch(() => {
                    return
                })
            },
            handleDragEnd() {
                let data = JSON.stringify(this.treeData)
                sortPermissions(data).then(res => {
                    if (res.data.response_status === "success") {
                        this.successCallback(res)
                    }
                })
            },
            successCallback(res) {
                if (res.data.response_status === "success") {
                    this.treeData = res.data.data
                    this.showForm = false
                    this.$message({
                        type: 'success',
                        showClose: true,
                        message: res.data.msg
                    })
                }
            }
        }
    };
</script>