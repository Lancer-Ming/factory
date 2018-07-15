<template>
    <div class="container" style="border: 1px solid #eee">
        <div :class="`edit-nav check-all-${header.id}`" v-for="(header,index) in edit_header">
                <div class="edit_firstmenu">  
                    <el-checkbox v-model="permission_id" @change="handleCheckAllChange(header)" :label="header.id" :key="index">{{header.label}}</el-checkbox>
                </div>
                <div :class="`edit_box clearfix check-${item.id}`" v-for="(item,index) in header.children">
                    <div class="edit-secondmenu clearfix">
                            <el-checkbox v-model="permission_id" @change="handleCheckTwo(item)" :label="item.id" :key="index" style="color: #3a5aaa;">{{item.label}}</el-checkbox>
                    </div>
                    <div class="edit_box2" v-for="(child,child_index) in item.children">
                        <div class="edit-threemenu clearfix">
                                <el-checkbox v-model="permission_id" @change="handleCheckThree(child)" :label="child.id" :key="child_index" style="color: #7f47a3;">{{child.label}}</el-checkbox>
                        </div>
                        <div class="edit-fourmenu" v-if="child.children.length > 0">
                                <el-checkbox  v-model="permission_id" @change="handleCheckAllChange(children)" :label="children.id" v-for="(children,children_index) in child.children" :key="children_index" style="color: #aa5f3a;">{{children.label}}</el-checkbox>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
    import { FindChildren } from '../utils/common.js'
    export default {
        name: 'edit_permission',
        data() {
            return {
                edit_header: [],
                permission_id: [],
                checked: false
            }
        },
        created() {
            let role_id = this.$route.params.id
            this.axios.get(`/role/${role_id}/permission`).then(res => {
                this.edit_header = res.data.data.permissions
            })

        },
        methods: {
            handleCheckAllChange(object) {
                let ids = []
                let findChildren = new FindChildren(ids)
                ids = findChildren.childRecursion(object)
                // console.log(ids)
                if(this.permission_id.indexOf(object.id) > -1) {
                    this.permission_id = this.permission_id.concat(ids)
                } else {
                    this.permission_id = this.permission_id.filter(item => {
                        return ids.indexOf(item) === -1
                    })
                }
               
            },
            handleCheckTwo(object) {
                let ids = []
                let findChildren = new FindChildren(ids)
                ids = findChildren.childRecursion(object)
                if(this.permission_id.indexOf(object.id) > -1) {
                    this.permission_id = this.permission_id.concat(ids)
                    if (this.permission_id.indexOf(object.parent_id) === -1) {
                        this.permission_id.push(object.parent_id)                        
                    }
                } else {
                    this.permission_id = this.permission_id.filter(item => {
                        return ids.indexOf(item) === -1 && item !== object.parent_id
                    })
                }
            },
            handleCheckThree(object) {
                let ids = []
                let findChildren = new FindChildren(ids)
                ids = findChildren.childRecursion(object)
                if(this.permission_id.indexOf(object.id) > -1) {
                    this.permission_id = this.permission_id.concat(ids)
                    if (this.permission_id.indexOf(object.parent_id) === -1) {
                        this.permission_id.push(object.parent_id)                        
                    }
                } else {
                    this.permission_id = this.permission_id.filter(item => {
                        return ids.indexOf(item) === -1 && item !== object.parent_id
                    })
                }
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