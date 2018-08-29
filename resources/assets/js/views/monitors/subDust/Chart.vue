<template>
    <div class="container Chart">

        <el-form ref="form" :model="form" label-width="120px" style="margin-top: 20px;">
            <el-form-item label="时间" size="mini">
                <el-date-picker
                        v-model="form.date"
                        type="date"
                        placeholder="选择日期">
                </el-date-picker>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" plain size="mini">查询</el-button>
            </el-form-item>
        </el-form>

        <el-table
                :data="tableData"
                border
                style="width: 100%">

            <el-table-column
                    prop="date"
                    label="时间"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="扬尘(ug/m³)"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="PM10（ug/m³）"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="PM2.5（ug/m³）"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="噪音（dB）"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="温度（℃）"
                    width="180"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop=""
                    label="风速（m/s）"
                    width="180"
                    align="center"
            >
            </el-table-column>
        </el-table>
            <chart-box :chart-data="dustData" :text="dustText" :subtext="dustSubtext"></chart-box>
            <chart-box :chart-data="pm10Data" :text="pm10Text" :subtext="pm10Subtext"></chart-box>
            <chart-box :chart-data="pm2Data" :text="pm2Text" :subtext="pm2Subtext"></chart-box>
            <chart-box :chart-data="noiseData" :text="noiseText" :subtext="noiseSubtext"></chart-box>
            <chart-box :chart-data="temperatureData" :text="temperatureText" :subtext="temperatureSubtext"></chart-box>
            <chart-box :chart-data="speedData" :text="speedText" :subtext="speedSubtext"></chart-box>
    </div>
</template>

<script>
    import ChartBox from '../../../components/ChartBox.vue'

    export default {
        components: {
            ChartBox
        },
        data() {
            return {
                form: {
                    date: ''
                },
                tableData: [],
                dustData: {
                    data: [1, 2, 2, 2, 2, 3],
                    id: 'dustChart'
                },
                pm10Data: {
                    data: [2, 10, 2, 3, 1, 5],
                    id: 'pm10Chart'
                },
                pm2Data: {
                    data: [2, 3, 3, 5, 5,1],
                    id: 'pm2Chart'
                },
                noiseData: {
                    data: [8, 3, 2, 3, 5, 2],
                    id: 'noiseChart'
                },
                temperatureData: {
                    data: [6, 3, 2, 3, 5, 1.5],
                    id: 'temperatureChart'
                },
                speedData: {
                    data: [5, 3, 2, 3, 5, 1],
                    id: 'speedChart'
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
                speedSubtext: 'm/s'
            }
        },

    }
</script>

<style>
    .Chart .el-form-item {
        width: 25%;
        float: left;
        padding-right: 60px;
    }
</style>