<template>
    <div class="container">
        <el-tree
                :data="treeData"
                node-key="id"
                :expand-on-click-node="false"
                @node-drag-start="handleDragStart"
                @node-drag-enter="handleDragEnter"
                @node-drag-leave="handleDragLeave"
                @node-drag-over="handleDragOver"
                @node-drag-end="handleDragEnd"
                @node-drop="handleDrop"
                draggable
                :allow-drop="allowDrop"
                :allow-drag="allowDrag">

            <span class="custom-tree-node" slot-scope="{ node, data }">
            <span>{{ node.label }}</span>
                <span>
                    <i class="el-icon-edit" @click="handleEdit(data)"></i>
                    <i class="el-icon-delete" @click="handleDelete(data)"></i>
                </span>
            </span>
        </el-tree>

        <el-dialog title="编辑菜单权限" :visible.sync="showForm" width="22%">
            <el-form :model="form">
                <el-form-item label="权限路由名" :label-width="formLabelWidth">
                    <el-input v-model="form.name" auto-complete="off" style="width:200px;" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="权限菜单名" :label-width="formLabelWidth">
                    <el-input v-model="form.label" auto-complete="off" style="width:200px;" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="图标icon" :label-width="formLabelWidth">
                    <el-input v-model="form.icon" auto-complete="off" style="width:250px;" size="mini"></el-input>
                </el-form-item>

                <el-form-item label="是否为菜单" :label-width="formLabelWidth">
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
    import { getPermissions, editPermissions, updatePermissions } from '../api/permission'
    export default {
        data() {
            return {
                treeData: [],
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },
                form: {
                    name: '',
                    label: '',
                    icon: '',
                    is_category: 0
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
                    this.treeData = res.data.data
                }
            })
        },
        methods: {
            handleDragStart(node, ev) {
                console.log('drag start', node);
            },
            handleDragEnter(draggingNode, dropNode, ev) {
                console.log('tree drag enter: ', dropNode.label);
            },
            handleDragLeave(draggingNode, dropNode, ev) {
                console.log('tree drag leave: ', dropNode.label);
            },
            handleDragOver(draggingNode, dropNode, ev) {
                console.log('tree drag over: ', dropNode.label);
            },
            handleDragEnd(draggingNode, dropNode, dropType, ev) {
                console.log('tree drag end: ', dropNode && dropNode.label, dropType);
            },
            handleDrop(draggingNode, dropNode, dropType, ev) {
                console.log('tree drop: ', dropNode.label, dropType);
            },
            allowDrop(draggingNode, dropNode, type) {
                if (dropNode.data.label === '二级 3-1') {
                    return type !== 'inner';
                } else {
                    return true;
                }
            },
            allowDrag(draggingNode) {
                return draggingNode.data.label.indexOf('三级 3-2-2') === -1;
            },

            submitForm() {
                if (this.formType === 'edit') {
                    updatePermissions(this.id, this.form).then(res => {
                        if (res.data.response_status === "success") {
                            this.treeData = res.data.data
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
                        this.id = editData.id
                        this.showForm = true
                    }
                })
            }
        }
    };
</script>