<template>
    <div class="container review" style="height: 100%;">
        <div class="review-box clearfix">
            <div class="review-left">
                <el-row class="review-tit">
                    <i class="el-icon-d-arrow-left tool" style="color: #8fbafe;float: right;"></i>
                </el-row>
                <el-row class="review-query">
                    <el-col :span="2">&nbsp;</el-col>
                    <el-col :span="11"><el-input size="mini"  v-model="filterText" style="width: 100%;margin-top: 5px;"></el-input></el-col>
                    <el-col :span="2">&nbsp;</el-col>
                    <el-col :span="9" class="query-text"></el-col>
                </el-row>
                <el-row>
                    <el-tree ref="tree" :filter-node-method="filterNode" :data="data" :props="defaultProps" :highlight-current="true" @node-click="handleNodeClick"></el-tree>
                </el-row>
            </div>
            <div class="review-right clearfix">
                <div class="review-r-box">

                </div>
                <div class="review-r-foot">
                    <i class="fa fa-stop"></i>
                    <i class="fa fa-camera-retro fa-lg"></i>
                    <i class="fa fa-microphone fa-lg fot-r"></i>
                </div>
            </div>
        </div>
        <div class="review-footer">

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
    .review-box{
        width: 100%;
        height: 95%;
        margin: 0 auto;
    }
    .review-left{
        width: 20%;
        height: 100%;
        float: left;
    }
    .review-right{
        width: 80%;
        height: 100%;
        float: left;
    }
    .review-footer{
        width: 100%;
        height: 5%;
        background: #000;
    }
    .review-tit{
        width:100%;
        padding: 10px 5px;
        background: #E0ECFF;
    }
    .review-query{
        width: 100%;
        margin: 20px auto;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    .review-r-box{
        width: 100%;
        height: 95%;
        background: #000;
    }
    .review-r-foot{
        width: 100%;
        height: 5%;
        border-left: 1px solid #e5e5e5;
        background: #fff;
    }
    .review-r-foot i{
        display: inline-block;
        color: #818080;
        margin: 10px 10px 0px 20px;
    }
    .fot-r{
        float: right;
        padding-right: 20px;
    }
</style>