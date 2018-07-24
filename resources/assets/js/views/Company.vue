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
                    width="300">
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
                    width="200">
                <template slot-scope="scope">
                    <i class="el-icon-time"></i> <span style="margin-left: 10px">{{ scope.row.created_at }}</span>
                </template>
            </el-table-column>

            <el-table-column
                    label="处理状态"
                    align="center"
                    width="200">
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ status[scope.row.status] }}</el-tag>
                    </div>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog title="编辑单位" :visible.sync="formShown" class="pro-add">
            <el-form class="clearfix">
                <el-form-item label="单位名称" :label-width="formLabelWidth">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="单位类型" :label-width="formLabelWidth">
                    <el-select v-model="form.unit_attr_id" placeholder="请选择项目类型">
                        <el-option v-for="(item,index) in options" :key="index" :label="item.label" :value="item.value"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="上级机构" :label-width="formLabelWidth">
                    <el-select v-model="form.utype_id" placeholder="请选择项目类型">
                        <el-option v-for="(item,index) in options" :key="index" :label="item.name" :value="item.name"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="单位属性" :label-width="formLabelWidth">
                    <el-select v-model="form.utype_id" placeholder="请选择项目类型">
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
    </div>
</template>

<script>
    import { getUtypes, getUnits, editUnit } from '../api/company'
    import { implode, decodeAddress } from '../utils/common'
    import { citys } from '../api/json'
    import { status, attrs } from '../config/company'
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
                editData: {},
                form: {
                    name: '',
                    unit_attr_id: 0,
                    utype_id: 0,
                    status: 0,
                    address: [],
                    detail: '',
                    utype_id: 0,
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
            handleEdit() {
                this.editOptions()  // 调用
                // 如果选中个数等于1的时候才触发编辑
                if (this.multipleSelection.length === 1) {
                    editUnit(this.multipleSelection[0]).then(res => {
                        this.editData = res.data.data
                        // 给form对象赋值
                        this.form = this.editData
                        this.form.address = [this.editData.province, this.editData.city, this.editData.county]
                        // 显示dialog编辑框
                        this.formShown = true
                    })
                }


            },
            handleDelete() {},
            onSubmit() {},
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
            },
            // 编辑的时候更改一下options
            editOptions() {
                this.options.unshift({label: '请选择', value: 0})
            }
        },
        computed: {
            status() {
                return status
            },
            attrs() {
                return attrs
            }
        }
    }
</script>


