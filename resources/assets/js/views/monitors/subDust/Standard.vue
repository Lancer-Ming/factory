<template>
    <div class="container Standard">
        <el-form ref="form" :model="form" label-width="120px" size="mini" style="margin-top: 20px;">
            <el-form-item label="SN">
                <el-input v-model="form.sn"></el-input>
            </el-form-item>
            <el-form-item label="监测点">
                <el-input v-model="form.address"></el-input>
            </el-form-item>
            <el-form-item label="监测站名称">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="success" plain>查询</el-button>
                <el-button type="success" plain>清空</el-button>
            </el-form-item>
        </el-form>

        <el-table
                :data="tableData"
                border
                style="width: 100%">
            <el-table-column
                    type="index"
                    width="50"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="item.name"
                    label="监测站名称"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="监测点"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="sn"
                    label="SN"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column label="扬尘预警" align="center">
                <el-table-column
                        prop="dust_standard.a34001_Rtd_pre_warning"
                        label="（ug/m³）"
                        width="120"
                        align="center"
                >
                </el-table-column>
            </el-table-column>
            <el-table-column label="扬尘报警" align="center">
                <el-table-column
                        prop="dust_standard.a34001_Rtd_is_warning"
                        label="（ug/m³）"
                        width="120"
                        align="center"
                >
                </el-table-column>
            </el-table-column>
            <el-table-column label="PM10预警" align="center">
                <el-table-column
                        prop="dust_standard.a34002_Rtd_pre_warning"
                        label="（ug/m³）"
                        width="120"
                        align="center"
                >
                </el-table-column>
            </el-table-column>
            <el-table-column label="PM10报警" align="center">
                <el-table-column
                        prop="dust_standard.a34002_Rtd_is_warning"
                        label="（ug/m³）"
                        width="120"
                        align="center"
                >
                </el-table-column>
            </el-table-column>
            <el-table-column label="PM2.5预警" align="center">
                <el-table-column
                        prop="dust_standard.a34004_Rtd_pre_warning"
                        label="（ug/m³）"
                        width="120"
                        align="center"
                >
                </el-table-column>
            </el-table-column>
            <el-table-column label="PM2.5报警" align="center">
                <el-table-column
                        prop="dust_standard.a34004_Rtd_is_warning"
                        label="（ug/m³）"
                        width="120"
                        align="center"
                >
                </el-table-column>
            </el-table-column>
            <el-table-column
                    prop="dust_standard.a01001_Rtd_high_pre_warning"
                    label="温度上限预警"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="dust_standard.a01001_Rtd_high_is_warning"
                    label="温度上限报警"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="dust_standard.a01001_Rtd_low_pre_warning"
                    label="温度下限预警"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="dust_standard.a01001_Rtd_low_is_warning"
                    label="温度下限报警"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="dust_standard.LA_Rtd_pre_warning"
                    label="噪音上限预警"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="dust_standard.LA_Rtd_is_warning"
                    label="噪音上限报警"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="dust_standard.a01007_Rtd_pre_warning"
                    label="风速上限预警"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="dust_standard.a01007_Rtd_is_warning"
                    label="风速上限报警"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="dust_standard.a01006_Rtd_high_is_warning"
                    label="气压上限预警"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="dust_standard.a01006_Rtd_low_is_warning"
                    label="	气压上限报警"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="dust_standard.a01002_Rtd_pre_warning"
                    label="湿度上限预警"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="dust_standard.a01002_Rtd_is_warning"
                    label="湿度上限报警"
                    width="120"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    prop="dust_standard.remark"
                    label="备注"
                    width="120"
                    align="center"
            >
            </el-table-column>
        </el-table>
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
    import {getstandard} from '../../../api/standard'
    import {pagesize, perPagesize} from '../../../config/common'

    export default {
        data() {
            return {
                form: {
                    sn: '',
                    address: '',
                    name: '',
                },
                tableData: [],
                currentPage: 1, //当前页数
                pagesize: pagesize,
                perPagesize: perPagesize,
                total: null,
                distribution: false,
            }
        },
        created() {
            this.getTabdata()
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
            getTabdata() {
                getstandard(this.currentPage, this.$route.query.sn, this.pagesize).then(res => {
                    if (res.data.response_status === "success") {
                        console.log(res)
                        this.tableData = res.data.data

                    }
                })
            }
        }

    }

</script>
<style>
    .Standard .el-form-item {
        width: 20%;
        float: left;
    }
</style>