<template>
    <div class="container Information">
        <el-form ref="form" :model="form" label-width="120px" style="margin-top: 20px;">
            <el-form-item label="时间" size="mini">
                <el-date-picker
                        v-model="form.date"
                        type="date"
                        placeholder="选择日期">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="报警类型" size="mini">
                <el-select v-model="form.alarm_type" placeholder="报警类型">
                    <el-option v-for="(item,index) in alarm_type" :label="item.name" :key='index' :value="item.id"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="预警状态" size="mini">
                <el-select v-model="form.region" placeholder="请选择活动区域">
                    <el-option label="全部" value="whole"></el-option>
                    <el-option label="预警" value="warning"></el-option>
                    <el-option label="报警" value="danger"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label=""  size="mini" style="width: 15%;">
                <el-checkbox  name="type"></el-checkbox>
            </el-form-item>
            <el-form-item label="开启自动查询" size="mini">
            </el-form-item>
            <el-form-item size="mini">
                <el-button type="danger" plain size="mini">查询</el-button>
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
            <el-table-column
                    prop="dust"
                    label="扬尘(ug/m³)"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM10"
                    label="PM10I(ug/m³)"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM2"
                    label="PM2.5(ug/m³)"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM2"
                    label="噪音(dB)"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM2"
                    label="温度(℃)"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM2"
                    label="湿度(%)"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM2"
                    label="露点(℃)"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM2"
                    label="气压(mbar)"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM2"
                    label="风级"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM2"
                    label="风向"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="PM2"
                    label="国测点距离"
                    width="120"
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
    import { alarm_type } from "../../../api/json"
    export default{
        data(){
            return{
                form:{
                    date: '',
                    alarm_type: '',
                    region: '',
                },
                tableData: [],
                alarm_type: [],
                data: [],
            }
        },
        created(){
            alarm_type().then(res => {
                this.alarm_type = res.data.alarm_type
            })
        }

    }
</script>
<style>
    .Information .el-form-item{
        width: 25%;
        float: left;
        padding-right: 60px;
    }
</style>