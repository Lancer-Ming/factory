<template>
    <div class="container content-container company-page">
        <div class="toolsbar">
            <el-row class="btnBox">
                <el-button
                        size="mini"
                        type="primary"
                        icon="el-icon-plus"
                        @click="handleAdd">新增
                </el-button>
                <el-button
                        size="mini"
                        type="primary"
                        plain
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
                        @click="importData">导入
                </el-button>
                <el-button
                        size="mini"
                        icon="el-icon-download"
                        @click="downloadTmp">模板下载
                </el-button>
                <el-button
                        size="mini"
                        icon="el-icon-download"
                        @click="exportCurrentData">导出当前数据
                </el-button>
                <el-button
                        size="mini"
                        icon="el-icon-download"
                        @click="exportAllData">导出全部数据
                </el-button>
            </el-row>
            <div class="searchBox">
                <el-row>
                    <el-form :inline="true" size="mini">
                        <el-form-item label="企业名称">
                            <el-input v-model="name" placeholder="请输入内容"></el-input>
                        </el-form-item>
                        <el-form-item label="法人代表">
                            <el-input v-model="leader" placeholder="请输入法人代表"></el-input>
                        </el-form-item>
                        <el-form-item label="单位类型">
                            <el-select v-model="utype_id" multiple filterable placeholder="请选择" value-key="item">
                                <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-button type="primary" plain size="mini" @click="search" icon="el-icon-search">搜索</el-button>
                        <el-button>重置</el-button>
                    </el-form>
                </el-row>
            </div>
        </div>
        <el-table
                :data="tableData"
                align
                border
                stripe
                v-loading="loading"
                @selection-change="handleSelectionChange"
                @row-click="cellClick"
                @row-dblclick="dblclick"
                ref="table"
                style="width: 100%"
        >
            <el-table-column
                    align="center"
                    width="25"
                    fixed
            >
                <template slot-scope="scope">
                    <span>{{ scope.row.id }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    align="center"
                    type="selection"
                    width="30"
            >
            </el-table-column>
            <el-table-column
                    label="编号"
            >
                <template slot-scope="scope">
                    <span>{{ scope.row.unit_no }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="企业名称"
            >
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <span>{{ scope.row.name }}</span>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="单位类型"
                    width="100"
            >
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <span>{{ implode(scope.row.utypes, 'name').join(',') }}</span>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="单位地址"
                    width="250"
            >
                <template slot-scope="scope">
                    <div slot="reference" class=" name-wrapper">
                        <span class="text-els">{{ decodeAddress(scope.row.province, scope.row.city, scope.row.county)+(scope.row.detail ? scope.row.detail : '') }}</span>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="法人代表"
                    align="center"
            >
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <span>{{ scope.row.leader }}</span>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="邮箱"
                    align="center"
            >
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <span>{{ scope.row.leader_tel }}</span>
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
                        <span>{{ status[scope.row.status] }}</span>
                    </div>
                </template>
            </el-table-column>
        </el-table>
        <!--分页-->
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
                <el-form-item label="邮箱" :label-width="formLabelWidth">
                    <el-input v-model="form.email"></el-input>
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
                    <el-button type="primary" @click="onSubmit" style="margin:10px 0px 0px 50px;">保存</el-button>
                    <el-button>取消</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>


        <el-dialog title="导入EXCEL" :visible.sync="excelDialogShow" class="pro-add">
            <div class="app-container">
                <upload-excel-component :on-success='handleSuccess' :before-upload="beforeUpload"></upload-excel-component>
                <el-table :data="excelData" border highlight-current-row style="width: 100%;margin-top:20px;">
                    <el-table-column v-for='item of excelHeader' :prop="item" :label="item" :key='item'>
                    </el-table-column>
                </el-table>
            </div>
            <el-button type="success" @click="importExcel">上传</el-button>
        </el-dialog>

        <search-box :chose="chose" v-on:dbClickSelection="getUnitValue" v-on:closeSearchBox="closeUnitValue"></search-box>
    </div>
</template>

<script>
    import UploadExcelComponent from '../../components/UploadExcel/index.vue'
    import {
        getUtypes,
        getUnits,
        editUnit,
        findUnit,
        updateUnit,
        storeUnit,
        destroyUnit,
        exportSelection,
        importExcel
    } from '../../api/company'
    import {implode, decodeAddress, encodeAddress, formatJson} from '../../utils/common'
    import {citys} from '../../api/json'
    import {status, attrs, exportTemp, tHeader, filterVal} from '../../config/company'
    import {pagesize, perPagesize} from '../../config/common'
    import SearchBox from '../../components/SearchBox.vue'
    import {export_json_to_excel} from '../../vendor/Export2Excel'
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
                submitType: '',
                filename: '',
                autoWidth: true,

                //excel
                excelData: [],
                excelHeader: [],
                excelDialogShow: false,
                finalExcelData: [],
                importExcelDataSwitch: false
            }
        },
        created() {
            this.$router.replace({path: this.$route.path, query: {page: this.currentPage}})

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
                    utype_id: []
                }
                this.formShown = true
                this.submitType = 'add'
            },
            handleSelectionChange(selection) {
                this.multipleSelection = implode(selection, 'id')
            },
            handleEdit() {
                this.submitType = 'edit'
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

                        findUnit(this.editData.id).then(res => {
                            this.units.push(res.data.data)
                        })
                    })
                }
            },
            handleDeleteSeleted() {
                this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    destroyUnit({id: this.multipleSelection}, this.currentPage, this.pagesize).then(res => {
                        if (res.data.response_status === 'success') {
                            this.tableData = res.data.data.data
                            this.$message({
                                type: 'success',
                                showClose: true,
                                message: res.data.msg
                            })
                        }
                    })
                }).catch(() => {
                    return
                })
            },
            handleSizeChange(pagesize) {
                this.pagesize = pagesize
                this.getTableData(this.searchData)
            },
            handleCurrentChange(currentPage) {
                this.currentPage = currentPage
                this.$router.replace({path: this.$route.path, query: {page: this.currentPage}})
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
                this.submitType = 'edit'
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
            formatJson(filterVal, jsonData) {
                return formatJson(filterVal, jsonData)
            },
            decodeAddress(province_code, city_code, county_code) {
                let resultArr = []
                resultArr = decodeAddress(this.addressData, province_code, city_code, county_code)
                return resultArr.join('')
            },
            encodeAddress(province, city, county) {
                let resultArr = []
                resultArr = encodeAddress(this.addressData, province, city, county)
                return resultArr
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
                this.$set(this.form, 'parent_id', row.id)
            },
            importData() {
                this.excelDialogShow = true
            },
            downloadTmp() {
                const list = exportTemp
                const data = this.formatJson(filterVal, list)
                this.filename = 'company'
                export_json_to_excel({
                    header: tHeader,
                    data,
                    filename: this.filename,
                    autoWidth: this.autoWidth
                })

            },
            exportCurrentData() {
                if (this.multipleSelection.length > 0) {
                    exportSelection(this.multipleSelection).then(res => {
                        if (res.data.response_status === 'success') {
                            const list = this.formatUnitExportData(res.data.data)
                            const data = this.formatJson(filterVal, list)
                            this.filename = 'company-select'
                            export_json_to_excel({
                                header: tHeader,
                                data,
                                filename: this.filename + Math.random().toString(36).substr(2),
                                autoWidth: this.autoWidth
                            })
                        }
                    })
                }
            },
            exportAllData() {
            },
            closeUnitValue() {
                this.chose = false
            },
            formatUnitExportData(units) {
                const result = []
                units.forEach(item => {
                    result.push({
                        id: item.id,
                        name: item.name,
                        utypes: implode(item.utypes, 'name').join(','),
                        parent_id: item.parent.name,
                        unit_attr_id: attrs.filter(v => {
                            return v.value === item.unit_attr_id
                        })[0].label,
                        status: status[item.status],
                        address: this.decodeAddress(item.province, item.city, item.county) + (item.detail ? item.detail : ''),
                        unit_no: item.unit_no,
                        qualification_no: item.qualification_no,
                        safety_permit: item.safety_permit,
                        leader: item.leader,
                        leader_tel: item.leader_tel,
                        concact_person: item.concact_person,
                        concact_tel: item.concact_tel,
                        email: item.email,
                        company_site: item.company_site,
                        fax: item.fax,
                        main_business: item.main_business,
                        remark: item.remark,
                    })
                })
                return result
            },
            beforeUpload(file) {
                const isLt1M = file.size / 1024 / 1024 < 1

                if (isLt1M) {
                    return true
                }

                this.$message({
                    message: 'Please do not upload files larger than 1m in size.',
                    type: 'warning'
                })
                return false
            },
            handleSuccess({results, header}) {
                this.excelData = results
                this.excelHeader = header
            },
            importExcel() {
                this.finalExcelData = this.formatUnitimportData(this.excelData)
            },
            formatUnitimportData: function (units) {
                const result = []
                units.forEach((item, index) => {
                    const utypes = item['单位类型'].split(',')
                    const parent_unit = item['上级机构']
                    importExcel({utypes, parent_unit}).then(res => {
                        //打开excel数据处理完毕的开关
                        if (units.length - 1 === index) {
                            this.importExcelDataSwitch = true
                        }
                        const utype_id = res.data.data.utype_id
                        const parent_id = res.data.data.parent_id

                        const address = item['单位地址'].split(' ')
                        const addressCode = this.encodeAddress(address[0], address[1], address[2])
                        result.push({
                            id: parseInt(item['Id']),
                            name: item['单位名称'],
                            utype_id,
                            parent_id,
                            unit_attr_id: attrs.filter(v => {
                                return v.label === item['单位属性']
                            })[0].value,
                            status: status.indexOf(item['单位审核状态']),
                            province: addressCode[0] || '',
                            city: addressCode[1] || '',
                            county: addressCode[2] || '',
                            unit_no: item['单位机构代码'],
                            qualification_no: item['资质证书编号'],
                            safety_permit: item['安全生产许可证'],
                            leader: item['法人代表'],
                            leader_tel: item['法人电话'],
                            concact_person: item['联系人'],
                            concact_tel: item['联系电话'],
                            email: item['邮箱'],
                            company_site: item['企业网址'],
                            fax: item['传真'],
                            main_business: item['主营业务'],
                            remark: item['描述'],
                        })
                    })
                })
                return result
            },
        },
        computed: {
            status() {
                return status
            },
            attrs() {
                return attrs
            }
        },
        watch: {
            importExcelDataSwitch(val) {
                if (val) {
                    const finalExcelData = this.finalExcelData
                    const pagesize = this.pagesize
                    importExcel({finalExcelData, pagesize}).then(res => {
                        if (res.data.response_status === 'success') {
                            this.importExcelDataSwitch = false
                            this.excelDialogShow = false
                            //总条数
                            this.total = res.data.data.total
                            //table显示的数据
                            this.tableData = res.data.data.data
                            // 加载loading
                            this.loading = false
                        }
                    })
                }
            }
        },
        components: {
            SearchBox,
            UploadExcelComponent
        }
    }
</script>


