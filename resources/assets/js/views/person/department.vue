<template>
    <div class="container department-page">
        <div class="toolsbar">
            <div class="searchBox">
                <el-row>
                    <el-form :inline="true" size="mini">
                        <el-form-item label="编码">
                            <el-input v-model="unit_no" placeholder="编码"></el-input>
                        </el-form-item>
                        <el-form-item label="部门名称">
                            <el-input v-model="name" placeholder="部门名称"></el-input>
                        </el-form-item>
                        <el-form-item label="状态">
                            <el-select v-model="form.status_id" placeholder="请选择单位状态">
                                <el-option
                                        v-for="(item,index) in d_status"
                                        :key="index"
                                        :label="item"
                                        :value="index"
                                >
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="单位名称">
                            <el-input v-model="name" placeholder="单位名称"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="search">搜索</el-button>
                            <el-button>重置</el-button>
                        </el-form-item>
                        <!--<span class="search-label">企业名称：</span><el-input v-model="name" placeholder="请输入内容" size="mini" style="width: 200px;"></el-input>-->
                        <!--<span class="search-label" style="margin-left: 30px;">法人代表：</span><el-input v-model="leader" placeholder="请输入法人代表" size="mini" style="width: 200px;"></el-input>-->
                        <!--<el-form-item label="单位类型" label-width="120">-->
                        <!--<el-select v-model="utype_id" multiple filterable placeholder="请选择" value-key="item" size="mini">-->
                        <!--<el-option-->
                        <!--v-for="item in options"-->
                        <!--:key="item.value"-->
                        <!--:label="item.label"-->
                        <!--:value="item.value">-->
                        <!--</el-option>-->
                        <!--</el-select>-->
                        <!--</el-form-item>-->
                        <!--<el-button type="info" size="mini" @click="search" icon="el-icon-search">搜索</el-button>-->
                    </el-form>
                </el-row>
            </div>
            <el-row class="btnBox" style="padding: 10px;">
                <el-button
                        size="mini"
                        type="primary"
                        icon="el-icon-plus"
                        @click="handleAdd">新增
                </el-button>
                <el-button
                        size="mini"
                        type="info"
                        icon="el-icon-edit"
                        @click="handleEdit">编辑
                </el-button>
                <el-button
                        size="mini"
                        type="danger"
                        icon="el-icon-delete"
                        @click="handleDeleteSeleted">删除
                </el-button>
                <el-button
                        size="mini"
                        icon="el-icon-sort"
                        @click="">导入
                </el-button>
                <el-button
                        size="mini"
                        icon="el-icon-download"
                        @click="">模板下载
                </el-button>
                <el-button
                        size="mini"
                        icon="el-icon-download"
                        @click="">导出当前数据
                </el-button>
                <el-button
                        size="mini"
                        icon="el-icon-download"
                        @click="">导出全部数据
                </el-button>
            </el-row>
        </div>
        <el-table
                :data="tableData"
                align
                border
                v-loading="loading"
                @selection-change="handleSelectionChange"
                @row-click="cellClick"
                @row-dblclick="dblclick"
                ref="table"
                style="width: 100%">

            <el-table-column
                    align="center"
                    width="25px"
            >
                <template slot-scope="scope">
                    <span>{{ scope.row.id }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    type="selection"
            >
            </el-table-column>
            <el-table-column
                    label="编号"
                    align="center"
            >
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.unit_no }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="企业名称"
                    width="350"
            >
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ scope.row.name }}</el-tag>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="单位类型"
                    align="center"
            >
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ implode(scope.row.utypes, 'name').join(',') }}</el-tag>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="单位地址"
                    align="center"
            >
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ decodeAddress(scope.row.province, scope.row.city, scope.row.county)+scope.row.detail }}</el-tag>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="法人代表"
                    align="center"
            >
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ scope.row.leader }}</el-tag>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="邮箱"
                    align="center"
            >
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ scope.row.leader_tel }}</el-tag>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="创建时间"
                    align="center"
            >
                <template slot-scope="scope">
                    <i class="el-icon-time"></i> <span style="margin-left: 10px">{{ scope.row.created_at }}</span>
                </template>
            </el-table-column>

            <el-table-column
                    label="处理状态"
                    align="center"
            >
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ status[scope.row.status] }}</el-tag>
                    </div>
                </template>
            </el-table-column>
        </el-table>

        <el-row class="paginate">
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-sizes="[5, 10, 15, 20]"
                    :page-size="10"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="total">
            </el-pagination>
        </el-row>


        <el-dialog title="编辑单位" :visible.sync="formShown" class="pro-add">
            <el-form class="clearfix">
                <el-form-item label="单位名称" :label-width="formLabelWidth">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="单位类型" :label-width="formLabelWidth">
                    <el-select v-model="form.utype_id" placeholder="请选择单位类型" multiple>
                        <el-option v-for="(item,index) in options" :key="index" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="上级机构" :label-width="formLabelWidth">
                    <el-select v-model="form.parent_id" placeholder="请选择上级机构" disabled>
                        <el-option v-for="(item,index) in units" :key="index" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                    <el-button plain @click="searchUnitBox">...</el-button>
                </el-form-item>
                <el-form-item label="单位属性" :label-width="formLabelWidth">
                    <el-select v-model="form.unit_attr_id" placeholder="">
                        <el-option v-for="(item,index) in attrs" :key="index" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="单位审核状态" :label-width="formLabelWidth">
                    <el-select v-model="form.status" placeholder="请选择">
                        <el-option v-for="(item,index) in status" :key="index" :label="item" :value="index"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="所在省市区" :label-width="formLabelWidth">
                    <el-cascader v-model="form.address" :options="addressData"></el-cascader>
                </el-form-item>
                <el-form-item label="详细地址" :label-width="formLabelWidth">
                    <el-input v-model="form.detail"></el-input>
                </el-form-item>

                <el-form-item label="单位机构代码" :label-width="formLabelWidth">
                    <el-input v-model="form.unit_no"></el-input>
                </el-form-item>
                <el-form-item label="资质证书编号" :label-width="formLabelWidth">
                    <el-input v-model="form.qualification_no"></el-input>
                </el-form-item>
                <el-form-item label="安全生产许可证" :label-width="formLabelWidth">
                    <el-input v-model="form.safety_permit"></el-input>
                </el-form-item>
                <el-form-item label="联系人" :label-width="formLabelWidth">
                    <el-input v-model="form.concact_person"></el-input>
                </el-form-item>
                <el-form-item label="联系电话" :label-width="formLabelWidth">
                    <el-input v-model="form.concact_tel"></el-input>
                </el-form-item>
                <el-form-item label="法人代表" :label-width="formLabelWidth">
                    <el-input v-model="form.leader"></el-input>
                </el-form-item>
                <el-form-item label="法人电话" :label-width="formLabelWidth">
                    <el-input v-model="form.leader_tel"></el-input>
                </el-form-item>
                <el-form-item label="企业网址" :label-width="formLabelWidth">
                    <el-input v-model="form.company_site"></el-input>
                </el-form-item>
                <el-form-item label="传真" :label-width="formLabelWidth">
                    <el-input v-model="form.fax"></el-input>
                </el-form-item>
                <el-form-item label="主营业务" :label-width="formLabelWidth">
                    <el-input type="textarea" v-model="form.main_business"></el-input>
                </el-form-item>
                <el-form-item label="描述" :label-width="formLabelWidth">
                    <el-input type="textarea" v-model="form.remark"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSubmit">保存</el-button>
                    <el-button>取消</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>

        <search-box :chose="chose" v-on:dbClickSelection="getUnitValue"></search-box>
    </div>
</template>

<script>
    import {getUtypes, getUnits, editUnit, findUnit, updateUnit, storeUnit} from '../../api/company'
    import {implode, decodeAddress} from '../../utils/common'
    import {citys} from '../../api/json'
    import {status,d_status, attrs} from '../../config/company'
    import {pagesize, perPagesize} from '../../config/common'
    import SearchBox from '../../components/SearchBox.vue'
    //import UploadExcelComponent from '../../components/UploadExcel/index.vue'
    export default {
        data() {
            return {
                //UploadExcelComponent,
                tableData: [],
                multipleSelection: [],
                options: [],
                units: [],
                leader: '',
                utype_id: '',
                name: '',
                unit_no:'',
                addressData: [],
                editData: {},
                currentPage: 1, //当前页数
                pagesize: pagesize,
                perPagesize: perPagesize,
                total: null,
                loading: true,
                searchData: {},
                chose: false,
                form: {
                    name: '',
                    unit_attr_id: null,
                    status_id:null,
                    parent_id: null,
                    status: 0,
                    address: [],
                    detail: '',
                    unit_no: '',
                    qualification_no: '',
                    safety_permit: '',
                    concact_person: '',
                    concact_tel: '',
                    leader: '',
                    leader_tel: '',
                    company_site: '',
                    fax: '',
                    main_business: '',
                    remark: ''
                },
                formShown: false,
                formLabelWidth: "120px",
                submitType: ''
            }
        },
        created() {
            citys().then(res => {
                this.addressData = res.data
            })
            getUtypes().then(res => {
                if (res.data.response_status === "success") {
                    this.options = res.data.data
                }
            })

            this.getTableData()

        },
        methods: {
            handleAdd() {
                this.form = {
                    name: '',
                    status_id:null,
                    unit_attr_id: null,
                    parent_id: null,
                    status: 0,
                    address: [],
                    detail: '',
                    unit_no: '',
                    qualification_no: '',
                    safety_permit: '',
                    concact_person: '',
                    concact_tel: '',
                    leader: '',
                    leader_tel: '',
                    company_site: '',
                    fax: '',
                    main_business: '',
                    remark: '',
                    utype_id: [],
                    d_status:[]
                }
                this.formShown = true
                this.submitType = 'add'
            },
            handleDeleteSeleted() {
            },
            handleSelectionChange(selection) {
                this.multipleSelection = implode(selection, 'id')
            },
            handleEdit() {
                findUnit(this.multipleSelection[0]).then(res => {
                    this.units.push(res.data.data)
                })
                // 如果选中个数等于1的时候才触发编辑
                if (this.multipleSelection.length === 1) {
                    editUnit(this.multipleSelection[0]).then(res => {
                        this.editData = res.data.data
                        // 给form对象赋值
                        this.form = this.editData
                        this.$set(this.form, 'address', [this.editData.province, this.editData.city, this.editData.county])
                        this.$set(this.form, 'utype_id', implode(this.editData.utypes, 'id'))
                        // 显示dialog编辑框
                        this.formShown = true
                    })
                }
                this.submitType = 'edit'
            },
            handleDelete() {
            },
            handleSizeChange(pagesize) {
                this.pagesize = pagesize
                this.getTableData(this.searchData)
            },
            handleCurrentChange(currentPage) {
                this.currentPage = currentPage
                this.getTableData(this.searchData)
            },
            onSubmit() {
                // 对要提交的数据进行简单的更改
                let data = this.form
                data.province = this.form.address[0]
                data.city = this.form.address[1]
                data.county = this.form.address[2]

                if (this.submitType === 'edit') {
                    updateUnit(this.editData.id, data).then(res => {
                        this.tableData.forEach((item, index) => {
                            if (item.id === this.editData.id) {
                                this.$set(this.tableData, index, res.data.data)
                                this.formShown = false
                                this.$message({
                                    type: 'success',
                                    showClose: true,
                                    message: res.data.msg
                                })
                            }
                        })
                    })
                } else {
                    storeUnit(data, this.pagesize).then(res => {
                        if (res.data.response_status === 'success') {
                            console.log(res)
                            this.tableData = res.data.data.data
                            this.formShown = false
                            this.$message({
                                type: 'success',
                                showClose: true,
                                message: res.data.msg
                            })
                        }
                    })
                }
            },
            search() {
                this.searchData = {leader: this.leader, name: this.name, utype_id: this.utype_id}
                this.getTableData(this.searchData)
            },
            cellClick(row) {
                this.$refs.table.toggleRowSelection(row)
            },
            dblclick(row) {
                this.$refs.table.clearSelection()
                this.$refs.table.toggleRowSelection(row, true)
                findUnit(row.id).then(res => {
                    this.units.push(res.data.data)
                    editUnit(row.id).then(res => {
                        this.editData = res.data.data
                        // 给form对象赋值
                        this.form = this.editData
                        this.$set(this.form, 'address', [this.editData.province, this.editData.city, this.editData.county])
                        this.$set(this.form, 'utype_id', implode(this.editData.utypes, 'id'))
                        // 显示dialog编辑框
                        this.formShown = true
                    })
                })
            },
            implode(arr, attr) {
                return implode(arr, attr);
            },
            decodeAddress(province_code, city_code, county_code) {
                let resultArr = []
                resultArr = decodeAddress(this.addressData, province_code, city_code, county_code)
                return resultArr.join('')
            },

            getTableData(data = {}) {
                getUnits(this.currentPage, data, this.pagesize).then(res => {
                    if (res.data.response_status === "success") {
                        //总条数
                        this.total = res.data.data.total
                        //table显示的数据
                        this.tableData = res.data.data.data
                        // 加载loading
                        this.loading = false
                    }
                })
            },
            searchUnitBox() {
                this.chose = true
            },

            getUnitValue(row) {
                this.chose = false
                this.$set(this.units, 0, {label: row.name, value: row.id})
                // this.units.push({label: row.name, value: row.id})
                this.form.parent_id = row.id
            },
        },
        computed: {
            d_status() {
                return d_status
            },
            status() {
                return status
            },
            attrs() {
                return attrs
            }
        },
        components: {
            SearchBox
        }
    }
</script>


