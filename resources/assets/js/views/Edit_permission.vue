<template>
    <div class="container" style="border: 1px solid #eee">
        <div :class="`edit-nav check-all-${header.id}`" v-for="(header,index) in edit_header">
                <div class="edit_firstmenu">  
                    <el-checkbox v-model="permission_id" @change="handleCheckAllChange(header)" :label="header.id" :key="index">{{header.label}}</el-checkbox>
                </div>
                <div :class="`edit_box clearfix check-${item.id}`" v-for="(item,index) in header.children">
                    <div class="edit-secondmenu clearfix">
                            <el-checkbox v-model="permission_id" @change="handleCheck(item)" :label="item.id" :key="index" style="color: #3a5aaa;">{{item.label}}</el-checkbox>
                    </div>
                    <div class="edit_box2" v-for="(child,child_index) in item.children">
                        <div class="edit-threemenu clearfix">
                                <el-checkbox v-model="permission_id" @change="handleCheck(child)" :label="child.id" :key="child_index" style="color: #7f47a3;">{{child.label}}</el-checkbox>
                        </div>
                        <div class="edit-fourmenu" v-if="child.children.length > 0">
                                <el-checkbox  v-model="permission_id" @change="handleCheck(children)" :label="children.id" v-for="(children,children_index) in child.children" :key="children_index" style="color: #aa5f3a;">{{children.label}}</el-checkbox>
                        </div>
                    </div>
                </div>
        </div>
        <div class="keep">
            <el-button type="info" @click="submit">保存修改</el-button>
        </div>
    </div>
</template>

<script>
    import { FindChildren,UnfoldAll } from '../utils/common.js'
    import { updatePermission,getPermission } from '../api/role'

    export default {
        name: 'edit_permission',
        data() {
            return {
                edit_header: [],
                permission_id: [],
                checked: false,
                role_id: null
            }
        },
        created() {
            this.role_id = this.$route.params.id
            getPermission(this.role_id).then(res => {
                this.edit_header = res.data.data.permissions
                this.permission_id = res.data.data.own_permissions_id
            })

        },
        methods: {
            handleCheckAllChange(object) {
                let ids = []
                console.log(object)
                let findChildren = new FindChildren(ids)
                ids = findChildren.childRecursion(object)
                if(this.permission_id.indexOf(object.id) > -1) {
                    this.permission_id = this.permission_id.concat(ids)
                } else {
                    this.permission_id = this.permission_id.filter(item => {
                        return ids.indexOf(item) === -1
                    })
                }
               
            },
            handleCheck(object) {
                this.checkRelation(object)
            },
            checkRelation(object) {
                let ids = []
                let findChildren = new FindChildren(ids)
                ids = findChildren.childRecursion(object)


                let unfoldAll = new UnfoldAll()
                let parents = unfoldAll.parentRecursion(this.edit_header)
                let parents_id = unfoldAll.findParent(object.id, parents)

                // 点亮
                if(this.permission_id.indexOf(object.id) > -1) {
                    this.permission_id = ids === undefined ? this.permission_id : this.permission_id.concat(ids)

                    this.permission_id = this.permission_id.concat(parents_id)
                } else {    // 取消
                    if (ids === undefined) return
                    this.permission_id = this.permission_id.filter(item => {
                        return ids.indexOf(item) === -1 && item !== object.parent_id
                    })
                }
            },
            submit(){
                updatePermission(this.role_id,this.permission_id).then(res => {
                    if (res.data.response_status === "success") {
                        this.$message({
                            type: 'success',
                            showClose: true,
                            message: res.data.msg
                        })
                       
                        this.$router.push({path: '/system/role/index'})
                       
                    }
                })
            }

        }
    }
</script>
<style>
    edit-nav {
        width: 100%;
        margin: 10px 0px;
        border: 1px solid #eee;
    }

    .edit_firstmenu {
        width: 100%;
        padding: 5px 10px;
        border-bottom: 1px solid #eee;
    }

    .edit_box {
        width: 100%;
        margin: 10px auto;
    }

    .edit-secondmenu{
        width: 20%;
        float: left;
    }
    .edit_box2{
        width: 80%;
        margin-left: 20%;
    }
    .edit-secondmenu label {
        display: block;
        padding: 0px 30px;
    }

    .edit-secondmenu label.el-checkbox + .el-checkbox {
        margin-left: 0px;
    }

    .edit-threemenu{
        float: left;
    }
    .edit-fourmenu{
        margin-left:50%;
    }
    .edit-threemenu .el-checkbox__label {
        padding-right: 15px;
    }
    .keep{
        width: 100px;
        margin: 20px auto;
    }
    .clearfix:after {
        display: block;
        visibility: hidden;
        font-size: 0;
        height: 0;
        content: '';
        clear: both;
    }

    .clearfix {
        zoom: 1;
    }
</style>