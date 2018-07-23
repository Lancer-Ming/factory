<template>
    <div class="container company-page">
        <div class="search">
        <el-row>
            <el-form>
                <span class="search-label">企业名称：</span><el-input v-model="name" placeholder="请输入内容" size="mini" style="width: 200px;"></el-input>
                <span class="search-label" style="margin-left: 30px;">法人代表：</span><el-input v-model="leader" placeholder="请输入法人代表" size="mini" style="width: 200px;"></el-input>
                <el-form-item label="单位类型" label-width="120" style="display: inline-block;width:300px;margin: 0 0 0 30px;">
                        <el-select v-model="utype_id" multiple filterable placeholder="请选择" value-key="item" size="mini">
                            <el-option
                                    v-for="item in options"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                </el-form-item>
                <el-button type="info" size="mini" @click="search">搜索</el-button>
            </el-form>
        </el-row>
        </div>
        <el-row style="padding: 10px;">
            <el-button
                    size="mini"
                    type="primary"
                    @click="handleAdd">新增
            </el-button>
            <el-button
                    size="mini"
                    type="info"
                    @click="handleEdit">编辑
            </el-button>
            <el-button
                    size="mini"
                    type="danger"
                    @click="handleDeleteSeleted">删除
            </el-button>
        </el-row>
        <el-table
                :data="tableData"
                align
                border
                height=600
                @selection-change="handleSelectionChange"
                @cell-click = "cellClick"
                ref="table"
                style="width: 100%">

            <el-table-column
                    type="selection"
                    width="55">
            </el-table-column>
            <el-table-column
                    label="编号"
                    align="center"
                    width="100">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.unit_no }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="企业名称"
                    align="center"
                    width="200">
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ scope.row.name }}</el-tag>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="单位类型"
                    align="center"
                    width="200">
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ implode(scope.row.utypes, 'name').join(',') }}</el-tag>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="单位地址"
                    align="center"
                    width="500">
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ decodeAddress(scope.row.province, scope.row.city, scope.row.county)+scope.row.detail }}</el-tag>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="法人代表"
                    align="center"
                    width="200">
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ scope.row.leader }}</el-tag>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="邮箱"
                    align="center"
                    width="200">
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ scope.row.leader_tel }}</el-tag>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="创建时间"
                    align="center"
                    width="300">
                <template slot-scope="scope">
                    <i class="el-icon-time"></i> <span style="margin-left: 10px">{{ scope.row.created_at }}</span>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    import { getUtypes, getUnits } from '../api/company'
    import { implode, decodeAddress } from '../utils/common'
    import { citys } from '../api/json'
    export default {
        data() {
            return {
                tableData: [],
                multipleSelection: [],
                options: [],
                leader: '',
                utype_id: '',
                name: '',
                page: 1,
                addressData: [],
            }
        },
        created() {
            citys().then(res => {
                this.addressData = res.data
            })
            getUtypes().then(res => {
                if (res.data.response_status === "success") {
                    res.data.data.forEach(item => {
                        this.options.push({
                            label: item.name,
                            value: item.id
                        })
                    })
                }
            })

            getUnits(this.page).then(res => {
                if (res.data.response_status === "success") {
                    this.tableData = res.data.data.data
                }
            })
        },
        methods: {
            handleAdd() {},
            handleDeleteSeleted() {},
            handleSelectionChange(selection) {
                this.multipleSelection = implode(selection, 'id')
            },
            handleEdit() {},
            handleDelete() {},
            search() {
                getUnits(this.page, {leader: this.leader, name: this.name, utype_id: this.utype_id}).then(res => {
                    if (res.data.response_status === "success") {
                        this.tableData = res.data.data.data
                    }
                })
            },
            cellClick(row) {
                this.$refs.table.toggleRowSelection(row)
            },
            implode(arr, attr) {
                return implode(arr, attr);
            },
            decodeAddress(province_code, city_code, county_code) {
                let resultArr = []
                resultArr = decodeAddress(this.addressData, province_code, city_code, county_code)
                return resultArr.join('')
            }
        }
    }
</script>
