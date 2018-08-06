<template>
    <div class="container current" style="height: 100%;">
        <div class="current-box clearfix">
            <div class="current-left">
                <el-row class="current-tit">
                    <i class="el-icon-d-arrow-left tool" style="color: #8fbafe;float: right;"></i>
                </el-row>
                <el-row class="current-query">
                    <el-col :span="2">&nbsp;</el-col>
                    <el-col :span="11"><el-input size="mini"  style="width: 100%;margin-top: 5px;"></el-input></el-col>
                    <el-col :span="2">&nbsp;</el-col>
                    <el-col :span="9" class="query-text"><el-button type="warning" icon="el-icon-search" plain size="mini">查询</el-button></el-col>
                </el-row>
                <el-row>
                    <el-tree :data="data" :props="defaultProps" :highlight-current="true" @node-click="handleNodeClick"></el-tree>
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
    import { getproject } from "../../api/project"
    export default {
        data(){
            return{
               data: [],
                defaultProps: {
                    children: 'units',
                    label: 'name'
                }
            }
        },
        created(){
            getproject().then(res=>{
                if (res.data.response_status === "success") {
                    this.data = res.data.data
                }
            })
        },
        methods:{
            handleNodeClick(){

            }
        }
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