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
        <chart-box :chart-data="dustData" :text="dustText" :subtext="dustSubtext"></chart-box>
        <chart-box :chart-data="pm10Data" :text="pm10Text" :subtext="pm10Subtext"></chart-box>
        <chart-box :chart-data="pm2Data" :text="pm2Text" :subtext="pm2Subtext"></chart-box>
        <chart-box :chart-data="noiseData" :text="noiseText" :subtext="noiseSubtext"></chart-box>
        <chart-box :chart-data="temperatureData" :text="temperatureText" :subtext="temperatureSubtext"></chart-box>
        <chart-box :chart-data="speedData" :text="speedText" :subtext="speedSubtext"></chart-box>

        <el-row style="margin-top: 20px;">
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-sizes="[30, 60, 90, 120]"
                    :page-size="pagesize"
                    :pager-count="11"
                    layout="total, sizes, prev, pager, next, jumper,slot,->"
                    :total="total">
            </el-pagination>
        </el-row>
    </div>
</template>

<script>
    import ChartBox from '../../../components/ChartBox.vue'
    import {getchart} from '../../../api/chart'
    import {pagesize, perPagesize} from '../../../config/common'


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
                data: [],
                dustData: {
                    data: [1, 2, 2, 2, 2, 3, 2, 2, 3, 2, 3],
                    id: 'dustChart'
                },
                pm10Data: {
                    data: [2, 10, 2, 3, 1, 5, 2, 2, 3, 2, 3],
                    id: 'pm10Chart'
                },
                pm2Data: {
                    data: [2, 3, 3, 5, 5, 1, 2, 2, 3, 2, 3],
                    id: 'pm2Chart'
                },
                noiseData: {
                    data: [8, 3, 2, 3, 5, 2, 2, 2, 3, 2, 3],
                    id: 'noiseChart'
                },
                temperatureData: {
                    data: [6, 3, 2, 3, 5, 1.5, 2, 2, 3, 2, 3],
                    id: 'temperatureChart'
                },
                speedData: {
                    data: [5, 3, 2, 3, 5, 1, 2, 2, 3, 2, 3],
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
                speedSubtext: 'm/s',
                currentPage: 1, //当前页数
                pagesize: pagesize,
                perPagesize: perPagesize,
                total: null,
                distribution: false,
            }
        },
        created() {
            this.getTableData()
        },
        methods: {
            handleSizeChange(val) {
                console.log(`每页 ${val} 条`);
            },
            handleCurrentChange(val) {
                console.log(`当前页: ${val}`);
            },
            handleCrane() {
                this.distribution = true
            },
            getTableData(time) {
                getchart(this.currentPage, this.$route.query.sn, this.pagesize,time).then(res => {
                    if (res.data.response_status === "success") {
                        console.log(res)
                        this.tableData = res.data.data
                        console.log(this.tableData)
                    }
                })
            },
            search(){
                this.getTableData(this.form.time)
            }
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