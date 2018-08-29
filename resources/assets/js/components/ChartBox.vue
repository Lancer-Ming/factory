<template>
    <span>
        <el-col :span="7"><div :id="chartData.id" style="width: 100%;height:400px;margin-top: 20px;"></div></el-col>
        <el-col :span="1"><div>&nbsp;</div></el-col>
    </span>
</template>
<script>
    // 引入基本模板
    let echarts = require('echarts/lib/echarts')
    // 引入柱状图组件
    require('echarts/lib/chart/bar')
    // 引入提示框和title组件
    require('echarts/lib/component/tooltip')
    require('echarts/lib/component/title')
    export default {
        data(){
            return{

            }
        },
        props:{
            chartData:{
                type: Object,
                default: {}
            },
            text:{
                type: String,
                default: ''
            },
            subtext:{
                type: String,
                default: ''
            }
        },
        mounted() {
            this.drawLine();
        },
        methods: {
            drawLine() {
                // 基于准备好的dom，初始化echarts实例
                var myChart = echarts.init(document.getElementById(this.chartData.id))
                // 绘制图表
                myChart.setOption({
                    title: {
                        text: this.text,
                        subtext: `单位:`+this.subtext
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: this.text
                    },
                    toolbox: {
                        show: true,
                        feature: {
                            dataView: {show: true, readOnly: false},
                            magicType: {show: true, type: ['line', 'bar']},
                            restore: {show: true},
                            saveAsImage: {show: true}
                        }
                    },
                    calculable: true,
                    xAxis: [
                        {
                            type: 'category',
                            data: ['0时', '2时', '4时', '6时', '8时', '10时']
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value'
                        }
                    ],
                    series: [
                        {
                            name: this.text,
                            type: 'line',
                            data: this.chartData.data,
                            markPoint: {
                                data: [
                                    {type: 'max', name: '最大值'},
                                    {type: 'min', name: '最小值'}
                                ]
                            },
                            markLine: {
                                data: [
                                    {type: 'average', name: '平均值'}
                                ]
                            }
                        }

                    ]
                });
            }

        }
    }
</script>