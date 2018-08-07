<template>
    <div class="container current" style="height: 100%;">
        <div class="current-box clearfix">
            <div class="current-left">
                <el-row class="current-tit">
                    <i class="el-icon-d-arrow-left tool" style="color: #8fbafe;float: right;"></i>
                </el-row>
                <el-row class="current-query">
                    <el-col :span="2">&nbsp;</el-col>
                    <el-col :span="11"><el-input size="mini"  v-model="filterText" style="width: 100%;margin-top: 5px;"></el-input></el-col>
                    <el-col :span="2">&nbsp;</el-col>
                    <el-col :span="9" class="query-text"></el-col>
                </el-row>
                <el-row>
                    <el-tree ref="tree" :filter-node-method="filterNode" :data="data" :props="defaultProps" :highlight-current="true" @node-click="handleNodeClick"></el-tree>
                </el-row>
            </div>
            <div class="current-right clearfix">
                <el-row style="width: 100%;height: 50%;">
                    <el-col :span="12">111111</el-col>
                    <el-col :span="12">222222</el-col>
                </el-row>
                <el-row>
                    <el-col :span="12">333333</el-col>
                    <el-col :span="12">444444</el-col>
                </el-row>
            </div>
        </div>
    </div>
</template>

<script>
    import { getItemWithDevice } from "../../api/current"
    export default {
        data(){
            return{
                filterText: '',
                data: [],
                defaultProps: {
                    children: 'devices',
                    label: 'd_name'
                }
            }
        },
        created(){
            getItemWithDevice().then(res=>{
                if (res.data.response_status === "success") {
                    this.data = res.data.data
                }
            })
        },
        methods:{
            handleNodeClick(){

            },
            filterNode(value, data) {
                console.log(value,data)
                if (!value) return true;
                return data.d_name.indexOf(value) !== -1;
            }
        },
        watch: {
            filterText(val) {
                this.$refs.tree.filter(val);
            }
        },
    }
</script>

<style>
    .current-box{
        width: 100%;
        margin: 0 auto;
        height: 100%;
    }
    .current-left{
        width: 20%;
        height: 100%;
        float: left;
    }
    .current-right{
        width: 80%;
        float: left;
        height: 100%;
    }
    .current-tit{
        width:100%;
        padding: 10px 5px;
        background: #E0ECFF;
    }
    .current-query{
        width: 100%;
        margin: 20px auto;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
</style>