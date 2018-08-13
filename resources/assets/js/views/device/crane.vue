<template>
    <div class="container crane">
        <split-pane v-on:resize="resize" split="vertical" :default-percent='20' :min-percent='10' class="projectBox" style="background: #fff;">
            <template slot="paneL">
                <div class="left-container">
                    <div class="crane-tit">
                        <el-row>
                            <i class="el-icon-d-arrow-left tool" style="color: #8fbafe;float: right;"></i>
                        </el-row>
                    </div>
                    <el-row class="crane-l-query">
                        <el-col :span="2">&nbsp;</el-col>
                        <el-col :span="11"><el-input size="mini" style="width: 100%;margin-top: 5px;"></el-input></el-col>
                        <el-col :span="2">&nbsp;</el-col>
                        <el-col :span="9" class="query-text"><el-button type="warning" icon="el-icon-search" plain size="mini">查询</el-button></el-col>
                    </el-row>

                </div>
            </template>
            <template slot="paneR">
                <div class="right-container">
                    <el-form ref="form" :model="form" label-width="120px" style="margin-top: 20px;">
                        <el-form-item label="塔机名称">
                            <el-input size="mini"></el-input>
                        </el-form-item>
                        <el-form-item label="塔机ID">
                            <el-input size="mini"></el-input>
                        </el-form-item>
                        <el-form-item label="塔机状态">
                            <el-select v-model="value" placeholder="请选择" size="mini">
                                <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value"
                                >
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="司机姓名">
                            <el-input size="mini"></el-input>
                        </el-form-item>
                        <el-form-item label="司机ID">
                            <el-input size="mini"></el-input>
                        </el-form-item>
                        <el-form-item label="黑匣子编号">
                            <el-input size="mini"></el-input>
                        </el-form-item>
                        <el-form-item label="监控厂商">
                            <el-input size="mini"></el-input>
                        </el-form-item>
                        <el-form-item label="监控状态">
                            <el-select v-model="value" placeholder="请选择" size="mini">
                                <el-option
                                        v-for="item in options1"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value"
                                >
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="IP">
                            <el-input size="mini"></el-input>
                        </el-form-item>
                        <el-form-item label="端口">
                            <el-input size="mini"></el-input>
                        </el-form-item>
                    </el-form>
                </div>
            </template>
        </split-pane>
    </div>
</template>

<script>
    import splitPane from 'vue-splitpane'
    export default {
        components: {
            splitPane,
        },
        data() {
            return {
                form: {

                },
                options: [
                    {
                    value: '选项1',
                    label: '在线'
                },
                    {
                    value: '选项2',
                    label: '离线'
                }],
                value: '',
                options1: [
                    {
                    value: '选项1',
                    label: '停用'
                    },
                    {
                        value: '选项2',
                        label: '监控'
                    }],
            }
        },
        methods: {
            resize() {
                console.log('resize')
            }
        }
    }

</script>

<style>
    .left-container{
        height: 100%;
        width: 100%;

    }
    .right-container{
        height: 100%;
    }
    .crane-tit{
        width:100%;
        padding: 10px 5px;
        background: #E0ECFF;
    }
    .crane-l-query{
        width: 100%;
        margin: 20px auto;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    .right-container .el-form-item{
        width: 33%;
        float: left;
    }

</style>
