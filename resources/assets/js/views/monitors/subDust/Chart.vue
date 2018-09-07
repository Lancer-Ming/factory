<template>
    <div class="container Chart">

        <el-form ref="form" :model="form" label-width="120px" style="margin-top: 20px;">
            <el-form-item label="时间" size="mini">
                <el-date-picker
                        v-model="form.time"
                        type="date"
                        placeholder="选择日期"
                        format="yyyy-MM-dd" value-format="yyyy-MM-dd"
                >
                </el-date-picker>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" plain size="mini" @click="search">查询</el-button>
            </el-form-item>
        </el-form>

        <el-table
                :data="tableData"
                border
                style="width: 100%">

            <el-table-column
                    label="时间"
                    width="180"
                    align="center"
            >
                <template slot-scope="scope">
                    <span>{{ scope.row.hour + '时' }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    prop="a34001_Rtd"
                    label="扬尘(ug/m³)"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="a34002_Rtd"
                    label="PM10（ug/m³）"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="a34004_Rtd"
                    label="PM2.5（ug/m³）"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="LA_Rtd"
                    label="噪音（dB）"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="a01001_Rtd"
                    label="温度（℃）"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="a01007_Rtd"
                    label="风速（m/s）"
                    width="180"
                    align="center"
            >
            </el-table-column>
        </el-table>
        <chart-box :chart-data="dustData.data" :id="dustData.id" :text="dustText" :subtext="dustSubtext" :hour="hour.data"></chart-box>
        <chart-box :chart-data="pm10Data.data" :id="pm10Data.id" :text="pm10Text" :subtext="pm10Subtext" :hour="hour.data"></chart-box>
        <chart-box :chart-data="pm2Data.data" :id="pm2Data.id" :text="pm2Text" :subtext="pm2Subtext" :hour="hour.data"></chart-box>
        <chart-box :chart-data="noiseData.data" :id="noiseData.id" :text="noiseText" :subtext="noiseSubtext" :hour="hour.data"></chart-box>
        <chart-box :chart-data="temperatureData.data" :id="temperatureData.id" :text="temperatureText" :subtext="temperatureSubtext" :hour="hour.data"></chart-box>
        <chart-box :chart-data="speedData.data" :id="speedData.id" :text="speedText" :subtext="speedSubtext" :hour="hour.data"></chart-box>
    </div>
</template>

<script>
    import ChartBox from '../../../components/ChartBox.vue'
    import {getchart} from '../../../api/chart'


    export default {
        components: {
            ChartBox
        },
        data() {
            return {
                form: {
                    time: ''
                },
                tableData: [],
                dustData: {
                    data: [],
                    id: 'dustChart'
                },
                pm10Data: {
                    data: [],
                    id: 'pm10Chart'
                },
                pm2Data: {
                    data: [],
                    id: 'pm2Chart'
                },
                noiseData: {
                    data: [],
                    id: 'noiseChart'
                },
                temperatureData: {
                    data: [],
                    id: 'temperatureChart'
                },
                speedData: {
                    data: [],
                    id: 'speedChart'
                },
                hour: {
                    data: []
                },
                dustText: '扬尘值',
                pm10Text: 'PM10',
                pm2Text: 'PM2.5',
                noiseText: '噪音值',
                temperatureText: '温度值',
                speedText: '风速值',
                dustSubtext: 'ug/m³',
                pm10Subtext: 'ug/m³',
                pm2Subtext: 'ug/m³',
                noiseSubtext: 'dB',
                temperatureSubtext: '℃',
                speedSubtext: 'm/s',
            }
        },
        created() {
            this.getTableData()
        },
        methods: {
            getTableData(time) {
                getchart(this.currentPage, this.$route.query.sn, this.pagesize, time).then(res => {
                    if (res.data.response_status === "success") {
                        var charts = {
                            timeSlot: [],
                            data: {
                                dust: [],
                                pm10: [],
                                pm2: [],
                                noise: [],
                                temperature: [],
                                speed: []
                            }
                        }
                        this.tableData = res.data.data
                        this.tableData.forEach(item => {
                            charts.timeSlot.push(item.hour)
                            charts.data.dust.push(item.a34001_Rtd)
                            charts.data.pm10.push(item.a34002_Rtd)
                            charts.data.pm2.push(item.a34004_Rtd)
                            charts.data.noise.push(item.LA_Rtd)
                            charts.data.temperature.push(item.a01001_Rtd)
                            charts.data.speed.push(item.a01007_Rtd)
                        })
                        this.hour.data = charts.timeSlot
                        this.dustData.data = charts.data.dust
                        this.pm10Data.data = charts.data.pm10
                        this.pm2Data.data = charts.data.pm2
                        this.noiseData.data = charts.data.noise
                        this.temperatureData.data = charts.data.temperature
                        this.speedData.data = charts.data.speed

                        console.log(charts)
                    }
                })
            },
            search() {
                this.getTableData(this.form.time)
            },

        }

    }
</script>

<style>
    .Chart .el-form-item {
        width: 25%;
        float: left;
        padding-right: 60px;
    }
</style>