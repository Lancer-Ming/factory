<template>
    <div class="container" style="border: 1px solid #eee">
        <div class="edit-nav" v-for="(header,index) in edit_header">
            <div class="edit_firstmenu">
                <el-checkbox :indeterminate="isIndeterminate" v-model="checkedFirst" @change="handleCheckAllChange" :key="index">{{header.label}}</el-checkbox>
            </div>
            <div class="edit_box clearfix" v-for="(item,index) in header.children">
                <div class="edit-secondmenu clearfix">
                    <el-checkbox-group v-model="checkedSecond" @change="handleCheckedSecondChange">
                        <el-checkbox :key="index" style="color: #3a5aaa;">{{item.label}}</el-checkbox>
                    </el-checkbox-group>
                </div>
                <div class="edit_box2" v-for="(child,child_index) in item.children">
                    <div class="edit-threemenu clearfix">
                        <el-checkbox-group v-model="checkedThree" @change="handleCheckedThreeChange">
                            <el-checkbox :key="child_index" style="color: #7f47a3;">{{child.label}}</el-checkbox>
                        </el-checkbox-group>

                    </div>
                    <div class="edit-fourmenu" v-if="child.children.length > 0">
                        <el-checkbox-group v-model="checkedFour" @change="handleCheckedFourChange">
                            <el-checkbox v-for="(children,children_index) in child.children" :key="children_index" style="color: #aa5f3a;">{{children.label}}</el-checkbox>
                        </el-checkbox-group>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'edit_permission',
        data() {
            return {
                edit_header: [],
                checkedFirst: false,
                checkedSecond: [],
                checkedThree: [],
                checkedFour: [],
                isIndeterminate: true
            }
        },
        created() {
            let role_id = this.$route.params.id
            this.axios.get(`/role/${role_id}/permission`).then(res => {
                this.edit_header = res.data.data.permissions
                console.log(this.edit_header)
            })

        },
        methods: {
            handleCheckAllChange(val) {
                this.checkedSecond = val ? this.edit_header : []
                this.isIndeterminate = false
            },
            handleCheckedSecondChange(value) {
                let checkedCount = value.length
                this.checkedFirst = checkedCount === this.edit_header.length
                this.isIndeterminate = checkedCount > 0 && checkedCount < this.edit_header.length
            },
            handleCheckedThreeChange(value) {
                let checkedOount = value.length
                this.checkedFirst = checkedOount === this.edit_header.length
                this.isIndeterminate = checkedOount > 0 && checkedOount < this.edit_header.length
            },
            handleCheckedFourChange(value){
                let checkedOount = value.length

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