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
                    <el-tree ref="tree" :filter-node-method="filterNode" :data="data" :props="defaultProps" highlight-current node-key="id" :expand-on-click-node="false" @node-click="handleNodeClick"></el-tree>
                </el-row>
            </div>
            <div class="current-right clearfix">
                <el-row v-if="currentAddressArray.length === 0">
                    <el-col>
                        <video id="myPlayer" poster="" controls playsInline webkit-playsinline autoplay style="width: 99%;height: 99%;" :data-id="currentTreeId">
                            <!-- <source :src="currentAddress.hlsHd" type="" /> -->
                            <source :src="currentAddressObject.hlsHd" type="application/x-mpegURL" />
                        </video>
                    </el-col>
              </el-row>

              <el-row v-if="currentAddressArray.length > 0" style="background: #000; height:100%;">
                  <el-col :span="12" v-for="address in currentAddressArray" :key="address.id" style="height: 50%" data-id="3">
                        <video id="myPlayer" poster="" controls playsInline webkit-playsinline autoplay style="width:100%;height:100%;" :data-id="currentTreeId">
                            <!-- <source :src="currentAddress.hlsHd" type="" /> -->
                            <div></div>
                            <source :src="address.hlsHd" type="application/x-mpegURL" />
                        </video>
                    </el-col>
              </el-row>

            </div>
        </div>
    </div>
</template>

<script>
    import { getItemWithDevice } from "../../api/current"
    import { implode } from '../../utils/common'
    export default {
        data(){
            return{
                filterText: '',
                data: [],
                defaultProps: {
                    children: 'devices',
                    label: 'd_name'
                },
                currentAddressObject: {},
                currentAddressArray: [],
                currentTreeId:null,
            }
        },
        created(){
            getItemWithDevice().then(res=>{
                if (res.data.response_status === "success") {
                    this.data = res.data.data
                    this.$nextTick(function(){
                        this.$refs.tree.setCurrentKey(this.data[0].id)
                        this.handleNodeClick(this.data[0])
                    })
                }
            })
        },
        methods:{
            handleNodeClick(data){
                console.log(data)
                if(this.currentTreeId === data.$treeNodeId){
                    return
                }
                this.currentTreeId = data.$treeNodeId
                // 如果点击的是设备
                if (typeof data.devices === 'undefined') {
                    this.currentAddressArray = []
                    if (this.currentAddressObject.hlsHd || this.currentAddressObject.hls) {
                        this.$nextTick(() => {
                            console.log(1)
                            $(`[data-id=${this.currentTreeId}]`).attr('src', '')
                        })
                    }
                    this.currentAddressObject = {
                        hls: data.hls,
                        hlsHd: data.hlsHd,
                        rtmp: data.rtmp,
                        rtmpHd: data.rtmpHd
                    }
                } else {
                    // 如果点击的是项目
                    if (data.devices.length === 0) {
                        this.currentAddressArray = [] 
                        this.$nextTick(() => {
                            console.log(2)
                            $(`[data-id=${this.currentTreeId}]`).attr('src', '')
                        })
                        return
                    }
                    data.devices.forEach(item => {
                        this.currentAddressArray.push({
                            hls: typeof  item.hls !== 'undefined' ? item.hls : '',
                            hlsHd: typeof item.hlsHd !== 'undefined' ? item.hlsHd : '',
                            rtmp: typeof item.rtmp !== 'undefined' ? item.rtmp : '',
                            rtmpHd: typeof item.rtmpHd !== 'undefined' ? item.rtmpHd : ''
                        })
                    })
                    this.currentAddressObject = {}
                }

                
            },
            filterNode(value, data) {
                if (!value) return true;
                return data.d_name.indexOf(value) !== -1;
            }
        },
        watch: {
            filterText(val) {
                this.$refs.tree.filter(val);
            }
        },
        implode() {

        },
        updated() {
            this.$nextTick(() => {
                let player1 = new EZUIPlayer('myPlayer');
            })
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