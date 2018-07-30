<template>
    <div class="container" style="position: relative;height: 100%;">
        <split-pane v-on:resize="resize" split="vertical" :default-percent='20' :min-percent='10' :max-percent='30' class="projectBox" style="background: #fff">
            <template slot="paneL">
                <div class="left-container">
                   <div class="video-tit">
                        <el-row>
                            <i class="el-icon-d-arrow-left tool" style="color: #8fbafe;float: right;"></i>
                        </el-row>
                   </div>
                    <el-row class="vide-l-query">
                        <el-col :span="2">&nbsp;</el-col>
                        <el-col :span="11"><el-input size="mini" style="width: 100%;margin-top: 5px;"></el-input></el-col>
                        <el-col :span="2">&nbsp;</el-col>
                        <el-col :span="9" class="query-text"><el-button type="warning" icon="el-icon-search" plain size="mini">查询</el-button></el-col>
                    </el-row>
                    <el-row>
                        <el-tree :data="data" :highlight-current="true"></el-tree>
                    </el-row>
                </div>
            </template>
            <template slot="paneR">
                <div class="right-container">
                    <el-row style="background: rgba(233,242,255,.5);padding: 5px 20px;">
                        <el-button type="primary" plain size="mini" icon="el-icon-circle-plus-outline" class="v-btn">添加摄像头</el-button>
                        <el-button type="primary" plain size="mini" icon="el-icon-sort" class="v-btn">复制添加摄像头</el-button>
                        <el-button type="primary" plain size="mini" icon="el-icon-delete" class="v-btn">删除摄像头</el-button>
                    </el-row>
                    <el-row style="margin: 20px 0px 0px 20px;">
                        摄像头名称：<el-input size="mini" style="width: 30%;"></el-input>
                        <el-button type="warning" plain class="pro-search" size="mini" icon="el-icon-search">搜索</el-button>
                    </el-row>
                    <el-table
                            ref="multipleTable"
                            :data="tableData3"
                            tooltip-effect="dark"
                            style="width: 100%;margin-top: 30px;"
                            @selection-change="handleSelectionChange"
                    >
                        <el-table-column
                                type="index"
                                width="50"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                type="selection"
                                width="55"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="name"
                                label="摄像头名称"
                                width="150"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="number"
                                label="设备序列号"
                                width="120"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="v_number"
                                label="设备通道号"
                                width="100"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="address"
                                label="直播源地址（EZOPEN协议，流畅）"
                                width="450"
                                align="center"
                                >
                        </el-table-column>
                        <el-table-column
                                prop="hls"
                                label="HLS播放地址（流畅）"
                                width="600"
                                align="center"
                                >
                        </el-table-column>
                    </el-table>
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
                tableData3: [{
                    name: '坝光环境3号球机',
                    number: 'C20322236',
                    v_number: '1',
                    address: 'ezopen://open.ys7.com/C20322236/1.live',
                    hls: 'http://hls.open.ys7.com/openlive/6778c087ad564b2ab7b13016c17ec7c3.m3u8'
                },
                    {
                    name: '坝光环境1号球机',
                    number: 'C14837868',
                    v_number: '1',
                    address: 'ezopen://open.ys7.com/C14837868/1.live',
                    hls: 'http://hls.open.ys7.com/openlive/b8735bbf5c0c4db8942b176644230b04.m3u8'
                },
                    {
                    name: '坝光环境2号球机',
                    number: 'C20322513',
                    v_number: '1',
                    address: 'ezopen://open.ys7.com/C20322513/1.live',
                    hls: 'http://hls.open.ys7.com/openlive/82d2e511fb2d472c815e6026a334399d.m3u8'
                }],
                multipleSelection: [],
                data: [{
                    label: '坝光片区场平工程(I标段)',
                    children: [{
                        label: '坝光片区场平工程(I标段)',
                    },
                        {
                            label: '坝光片区场平工程(I标段)'
                        }
                    ]
                },
                    {
                        label: '深圳市城市轨道交通3号线南延线工程主体工程3131标段（备份）',
                    },
                    {
                        label: '库坑片区路网完善工程新丹路（龙观快速—泗黎路）段工程',
                        children: [{
                            label: '深圳市建泰建筑劳务分包有限公司_黄汉辉(SZJTJZ)'
                        },
                            {
                                label: '中车信息技术有限公司'
                            },
                            {
                                label: '中车信息技术有限公司'
                            }
                        ]
                    },
                    {
                        label: '布吉河流域综合治理工程“EPC+O”（设计采购施工和管养一体化）',
                        children: [{
                            label: '湛江市同得利劳务有限公司'
                        },
                            {
                                label: '中车信息技术有限公司'
                            },
                            {
                                label: '深圳市市政工程总公司'
                            },
                            {
                                label: '深圳市聚豪建筑工程劳务分包有限公司'
                            },
                            {
                                label: '深圳市金润劳务工程有限公司'
                            },
                            {
                                label: '深圳市泰屹恒建筑劳务有限公司'
                            },
                            {
                                label: '广东进业劳务分包有限公司'
                            }
                        ]
                    }],
                }
            },
        methods:{
            resize() {
                console.log('resize')
            },
            toggleSelection(rows) {
                if (rows) {
                    rows.forEach(row => {
                        this.$refs.multipleTable.toggleRowSelection(row);
                    });
                } else {
                    this.$refs.multipleTable.clearSelection();
                }
            },
            handleSelectionChange(val) {
                this.multipleSelection = val;
            }
        }
    }
</script>
<style scoped>
    .left-container{
        height: 100%;
        width: 100%;
        overflow: hidden;
    }
    .right-container{
        height: 100%;
    }
    .video-tit{
        width:100%;
        padding: 10px 5px;
        background: #E0ECFF;
    }
    .vide-l-query{
        width: 100%;
        margin: 20px auto;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    .v-btn{
        border-radius: 15px;
    }
</style>