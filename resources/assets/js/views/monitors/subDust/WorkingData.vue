<template>
    <div class="container Working">
        <el-form ref="form" :model="form" label-width="120px" style="margin-top: 20px;">
            <el-form-item label="时间" size="mini">
                <el-date-picker
                        v-model="form.date"
                        type="date"
                        placeholder="选择日期">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="" style="width: 10%;" size="mini">
                <el-checkbox  name="type"></el-checkbox>
            </el-form-item>
            <el-form-item label="开启自动查询" size="mini">
            </el-form-item>
            <el-form-item size="mini">
                <el-button type="primary" plain size="mini">查询</el-button>
            </el-form-item>
        </el-form>

        <el-table
                :data="tableData"
                border
                style="width: 100%"
        >
            <el-table-column
                    prop="id"
                    align="center"
                    width="60"
                    fixed
                    sortable
                    label="#"
            >
            </el-table-column>
            <el-table-column
                    prop="SN"
                    label="SN"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="监控点名称"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="date"
                    label="时间"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column label="扬尘" align="center">
                <el-table-column
                        prop="dust"
                        label="(ug/m³)"
                        width="100"
                        align="center"
                >
                </el-table-column>
            </el-table-column>
            <el-table-column label="PM10" align="center">
                <el-table-column
                        prop="PM10"
                        label="(ug/m³)"
                        width="100"
                        align="center"
                >
                </el-table-column>
            </el-table-column>
            <el-table-column label="PM2.5" align="center">
                <el-table-column
                        prop="PM2"
                        label="(ug/m³)"
                        width="100"
                        align="center"
                >
                </el-table-column>
            </el-table-column>
            <el-table-column
                        prop="PM2"
                        label="噪音(dB)"
                        width="100"
                        align="center"
                >
            </el-table-column>

            <el-table-column
                    prop="PM2"
                    label="温度(℃)"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM2"
                    label="湿度(%)"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM2"
                    label="气压(mbar)"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM2"
                    label="风级"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM2"
                    label="风向"
                    width="100"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM2"
                    label="报警状态"
                    width="300"
                    align="center"
            >
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form:{
                    date: '',
                },
                tableData:[]
            }
        },
        methods:{
            renderheader(h, { column, $index }) {
                return h('span', {}, [
                    h('span', {}, column.label.split('/')[0]),
                    h('br'),
                    h('span', {}, column.label.split('/')[1])
                ])
            }
        }
    }
</script>

<style>
    .Working .el-form-item{
        width: 20%;
        float: left;
    }
</style>


