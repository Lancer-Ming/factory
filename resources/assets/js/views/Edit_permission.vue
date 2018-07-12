<template>
    <div class="container" style="border: 1px solid #eee">
        <div class="edit-nav" v-for="(header,index) in edit_header">
            <div class="edit_firstmenu">
                <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange" :key="index">{{header.label}}</el-checkbox>
            </div>
            <div class="edit_box clearfix" v-for="(item,index) in header.children">
                <div class="edit-secondmenu">
                    <el-checkbox-group v-model="checkedCities" @change="handleCheckedCitiesChange" >
                        <el-checkbox :key="index">{{item.label}}</el-checkbox>
                    </el-checkbox-group>
                </div>
                <div class="edit-threemenu">
                    <el-checkbox-group v-model="checkedOpeartions" @change="handleCheckedOpeartionsChange">
                        <el-checkbox v-for="(child,child_index) in item.children" :key="child_index">{{child.label}}</el-checkbox>
                    </el-checkbox-group>
                    <!--<div class="edit-fourmenu">-->
                        <!--<el-checkbox-group v-model="checkedOpeartions" @change="handleCheckedOpeartionsChange" v-if="item.children.length > 0">-->
                            <!--<el-checkbox v-for="(children,children_index) in child.children" :key="children_index">{{children.label}}</el-checkbox>-->
                        <!--</el-checkbox-group>-->
                    <!--</div>-->
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
                edit_header:[],
                checkAll: false,
                checkedCities: ['建筑工人库', '管理人员库'],
                checkedOpeartions:['删除','修改'],
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
                this.checkedCities = val ? edit_header : []
                this.checkedOpeartions = val ? edit_header : []
                this.isIndeterminate = false
            },
            handleCheckedCitiesChange(value) {
                let checkedCount = value.length
                this.checkAll = checkedCount === this.edit_header.length
                this.isIndeterminate = checkedCount > 0 && checkedCount < this.edit_header.length
            },
            handleCheckedOpeartionsChange(value) {
                let checkedOount = value.length
                this.checkAll = checkedOount === this.edit_header.length
                this.isIndeterminate = checkedOount > 0 && checkedOount < this.edit_header.length
            }
        }
    }
</script>
<style>
    edit-nav{
        width: 100%;
        margin: 10px 0px;
        border:1px solid #eee;
    }
    .edit_firstmenu{
        width:100%;
        padding:5px 10px;
        border-bottom:1px solid #eee;
    }
    .edit_box{
        width: 100%;
        margin: 10px auto;
    }
    .edit-secondmenu{
        width:20%;
        float: left;
    }
    .edit-secondmenu label{
        display: block;
        padding:0px 30px;
    }
    .edit-secondmenu label.el-checkbox+.el-checkbox{
        margin-left: 0px;
    }
    .edit-threemenu{
        width: 70%;
        float: left;
    }
    /*.edit-fourmenu{*/
        /*width: 25%;*/
        /*float: left;*/
    /*}*/
    .clearfix:after{
        display: block;
        visibility: hidden;
        font-size: 0;
        height: 0;
        content: '';
        clear: both;
    }
    .clearfix{
        zoom: 1;
    }
</style>