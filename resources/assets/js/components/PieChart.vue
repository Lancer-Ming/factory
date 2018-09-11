<template>
    <div id="myChart" style="width:50%;height:400px;margin-top:20px;float:left;"></div>
</template>
<script>
    // 引入基本模板
    let echarts = require('echarts/lib/echarts')
    // 引入柱状图组件
    require('echarts/lib/chart/pie')
    // 引入提示框和title组件
    require('echarts/lib/component/tooltip')
    require('echarts/lib/component/title')
    export default {
        data() {
            return {}
        },

        mounted() {
            this.drawLine();
        },
        methods: {
            drawLine() {
                // 基于准备好的dom，初始化echarts实例
                var myChart = echarts.init(document.getElementById("myChart"))
                // 绘制图表
                myChart.setOption({
                    title: {
                        text: '人员百分比',
                        subtext: '',
                        x: 'center'
                    },
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },
                    legend: {
                        orient: 'vertical',
                        left: 'left',
                        data: ['参建单位', '实名制验证', '人员类别', '人员状态', '工种','班组','年龄','籍贯','民族','学历']
                    },
                    series: [
                        {
                            name: '访问来源',
                            type: 'pie',
                            radius: '55%',
                            center: ['50%', '60%'],
                            data: [
                                {value: 335, name: '参建单位'},
                                {value: 310, name: '实名制验证'},
                                {value: 234, name: '人员类别'},
                                {value: 135, name: '人员状态'},
                                {value: 1548, name: '工种'},
                                {value:300,name:'班组'},
                                {value:340,name:'年龄'},
                                {value:240,name:'籍贯'},
                                {value:560,name:'民族'},
                                {value:320,name:'学历'},
                            ],
                            itemStyle: {
                                emphasis: {
                                    shadowBlur: 10,
                                    shadowOffsetX: 0,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            }
                        }
                    ]
                })
            }
        },

    }
</script>