<template>
    <div class="container content-container as-table__data company-page">
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
            <el-row class="searchBox">
                <el-form :inline="true" size="mini">
                    <el-form-item label="企业名称">
                        <el-input v-model="query.name" placeholder="请输入内容"></el-input>
                    </el-form-item>
                    <el-form-item label="法人代表">
                        <el-input v-model="query.leader" placeholder="请输入法人代表"></el-input>
                    </el-form-item>
                    <el-form-item label="单位类型">
                        <el-select v-model="query.utype_id" multiple filterable placeholder="请选择" value-key="item">
                            <el-option
                                    v-for="item in options"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-button type="primary" plain size="mini" @click="search" icon="el-icon-search">搜索</el-button>
                    <el-button native-type="reset" @click="reset">清空</el-button>
                </el-form>
            </el-row>
        </div>
        <div>
            <el-table
                    class="as-table"
                    :data="tableData"
                    border
                    stripe
                    size="mini"
                    :highlight-current-row="true"
                    :default-sort="{prop: 'id', order: 'ascending'}"
                    v-loading="loading"
                    @selection-change="handleSelectionChange"
                    ref="table"
                    @row-click="cellClick"
                    @row-dblclick="dblclick"
            >
                <el-table-column
                        type="selection"
                        width="30"
                        fixed
                >
                </el-table-column>
                <el-table-column
                        prop="id"
                        width="60"
                        fixed
                        sortable
                        label="#"
                >
                    <template slot-scope="scope">
                        <span>{{ scope.row.id }}</span>
                    </template>
                </el-table-column>
                <el-table-column
                        align="left"
                        label="单位机构代码"
                        width="150"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.unit_no }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        align="left"
                        label="企业名称"
                        width="200"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.name }}</span>
                        </div>
                    </template>
                </el-table-column>

                <el-table-column
                        align="left"
                        prop="utypes"
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
                        label="上级机构"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{scope.row.parent_id}}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        align="left"
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
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.leader }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="法人联系电话"
                        width="100"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.leader_tel }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="联系人"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.concact_person }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="联系人电话"
                        width="100"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.concact_tel }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="邮箱"
                        width="140"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.leader_tel }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="企业网址"
                        width="100"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.company_site }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="传真"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.fax }}</span>
                        </div>
                    </template>
                </el-table-column>


                <el-table-column
                        label="业务区域"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.region }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="资质等级"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.grade }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        align="left"
                        label="资质证书编号"
                        width="150"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.qualification_no }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="安全生产许可证"
                        width="110"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.safety_permit }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="主营业务"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.main_business }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="备注"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ scope.row.remark }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="单位状态"
                >
                    <template slot-scope="scope">
                        <div slot="reference" class="name-wrapper">
                            <span>{{ status[scope.row.status] }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                        label="更新时间"
                        width="165"
                        sortable
                        prop="updated_at"
                >
                    <template slot-scope="scope">
                        <i class="el-icon-time"></i> <span style="margin-left: 10px">{{ scope.row.updated_at }}</span>
                    </template>
                </el-table-column>
                <el-table-column
                        label="创建时间"
                        width="165"
                        sortable
                        prop="created_at"
                        fixed="right"
                >
                    <template slot-scope="scope">
                        <i class="el-icon-time"></i> <span style="margin-left: 10px">{{ scope.row.created_at }}</span>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <!--分页-->
        <el-row class="paginate">
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="currentPage"
                    :page-sizes="[30, 60, 90, 120]"
                    :page-size="30"
                    :pager-count="11"
                    layout="total, sizes, prev, pager, next, jumper,slot,->"
                    :total="total">
            </el-pagination>
        </el-row>
        <!--
        测试预留，误删！
        <el-dialog title="编辑单位" :visible.sync="formShown" class="pro-add" v-dialogDrag :close-on-click-modal="false"  fullscreen="true" ref="dialog__wrapper" @dragDialog="handleDrag">
            <div class="line" v-dialogDragWidth="$refs.dialog__wrapper">
        -->
        <el-dialog :visible.sync="formShown" v-dialogDrag :close-on-click-modal="false" class="pro-add" @dragDialog="handleDrag">
            <div slot="title">
                <span class="el-dialog__title">编辑单位</span>
                <button class="el-dialog_btn__fullscreen">
                </button>
            </div>
            <div class="line">
                <el-form class="clearfix" size="mini">
                    <el-form-item label="单位名称" :label-width="formLabelWidth">
                        <el-input v-model="form.name" size="mini"></el-input>
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
                </el-form>
            </div>
            <div slot="footer" class="dialog-footer">
                <el-button @click="formShown = false">取 消</el-button>
                <el-button type="primary" @click="onSubmit">保存</el-button>
            </div>
        </el-dialog>


        <el-dialog title="导入EXCEL" :visible.sync="excelDialogShow" v-dialogDrag :close-on-click-modal="false" class="pro-add">
            <div class="app-container">
                <upload-excel-component :on-success='handleSuccess' :before-upload="beforeUpload"></upload-excel-component>
                <el-table :data="excelData" border highlight-current-row style="width: 100%;margin-top:20px;">
                    <el-table-column v-for='item of excelHeader' :prop="item" :label="item" :key='item'>
                    </el-table-column>
                </el-table>
            </div>
            <div slot="footer" class="dialog-footer">
                <el-button @click="excelDialogShow = false">取 消</el-button>
                <el-button type="primary" @click="importExcel">保存</el-button>
            </div>
        </el-dialog>

        <search-box :chose="chose" v-on:dbClickSelection="getUnitValue" v-on:closeSearchBox="closeUnitValue"></search-box>
    </div>
</template>

<script>
    //import elDragDialog from '../../directive/el-dragDialog'
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

    export default {
        name: 'company',
        //directives: { elDragDialog },
        data() {
            return {
                query: {
                    leader: '', name: '', utype_id: null
                },
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
                chose: false,  //是否显示
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
            handleDrag() {
                //放大缩小事件预留
                //this.$refs.select
            },
            // filterHandler(value, row, column) {
            //     const property = column['property'];
            //     return row[property] === value;
            //
            // },
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
                this.getTableData(this.query)
            },
            reset() {
                for (var item in this.query) {
                    this.$set(this.query, item, '')
                }
                this.getTableData(this.query)
            },
            cellClick(row) {
                // this.$refs.table.toggleRowSelection(row)
                // this.$refs.table.clearSelection()
                this.$refs.table.toggleRowSelection(row, true)
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
                            //总条数
                            this.total = res.data.data.total
                            //table显示的数据
                            this.tableData = res.data.data.data
                            // 加载loading
                            this.loading = false

                            this.excelData = []
                            this.$message({
                                type: 'success',
                                showClose: true,
                                message: '操作成功！'
                            })
                            this.excelDialogShow = false
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


