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
    </div>
</template>

<script>
    export default{
        data(){
            return{
                form:{
                    date: ''
                },
                tableData: [],
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