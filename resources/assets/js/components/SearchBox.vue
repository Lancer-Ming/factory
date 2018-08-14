<template>
    <el-dialog title="弹出选择" :visible.sync="chose" class="chose" :before-close="handleClose">
        <el-form :model="form">
            <div style="width: 60%;margin: -20px 0px 10px 0px;" class="chose-name">
                名称：<el-input v-model="name"></el-input>
                <span class="search-btn" @click="unitSearch"><i class="el-icon-search"></i>查询</span>
                <span class="search-btn" @click="clearSearch"><i class="el-icon-delete"></i>清空</span>
            </div>
            <el-table 
            :data="tableData" 
            height="250" border style="width: 100%" 
            v-loading="loading"
            highlight-current-row
            @cell-dblclick="dbclick"
            >
                <el-table-column prop="unit_no" label="编号" width="100" align="center">
                </el-table-column>
                <el-table-column prop="name" label="名称" width="600" align="center">
                </el-table-column>
                <el-table-column>
                </el-table-column>
            </el-table>
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-sizes="[5, 10, 15, 20]"
                    :page-size="pagesize"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="total"
                    align="center"
                    style="margin-top: 20px;"
            >
            </el-pagination>
        </el-form>
        <div slot="footer" class="dialog-footer">
            <el-button @click="handleClose">取 消</el-button>
            <el-button type="primary" @click="dbclick">确 定</el-button>
        </div>
    </el-dialog>
</template>

<script>
import { unitForm,itemForm } from '../api/project'

    export default {
        data() {
            return {
                loading: true,
                tableData: [],
                currentPage: 1,
                pagesize: 10,
                name: '',
                total: null,

            }
        },
        props: {
            chose: {
                type: Boolean,
                default: false
            },
            currentUnitModel: {
                type: String,
                default: ''
            },
            requestName:{
                type: String,
                default: ''
            },
            form: {
                type: Object
            },

            // tableData: Array,
            // currentPage: Number

        },
        methods: {
            unitSearch() {
                this.getTableData(this.currentPage, this.name)
            },
            clearSearch() {
                this.name = ''
                this.getTableData(this.currentPage)
            },
            handleSizeChange(pagesize) {
                this.pagesize = pagesize
                this.getTableData()
            },
            handleCurrentChange(currentPage) {
                this.getTableData(currentPage)
            },
            handleClose() {
                this.$emit('closeSearchBox')
            },
            dbclick(row) {
                this.$emit('dbClickSelection', row)
            },
            // 请求数据
            getTableData(currentPage=this.currentPage, name="") {
                switch (this.requestName) {
                    case 'item': itemForm(currentPage, { name }, this.pagesize).then(res => {
                            if (res.data.response_status === 'success') {
                                this.tableData = res.data.data.data
                                this.total = res.data.data.total
                                this.loading = false
                            }
                        })
                        break;
                    case 'unit': unitForm(currentPage, {form_name: this.currentUnitModel, name}, this.pagesize).then(res => {
                        if (res.data.response_status === 'success') {
                            this.tableData = res.data.data.data
                            this.total = res.data.data.total
                            this.loading = false
                        }
                    })
                        break;
                }
            }
        },
        watch: {
            chose(val) {
                if (!val) {
                    return
                }
                this.getTableData(this.currentPage)
            }
        }    
    }
</script>

<style scoped>
    .chose-name i{
        display: inline-block;
        margin-right: 5px;
        margin-left: 5px;
    }
    .el-input {
        width: 50%;
    }
    .search-btn {
        cursor: pointer;
    }
</style>
