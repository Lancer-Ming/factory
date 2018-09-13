<template>
    <div class="container">
        <div class="toolsbar">
            <el-row class="btnBox">
                <el-button
                        size="mini"
                        type="primary"
                        @click="handleAdd">新增
                </el-button>
                <el-button
                        size="mini"
                        type="danger"
                        @click="handleDeleteSeleted">删除
                </el-button>
            </el-row>
            <!--<div class="searchBox">-->
            <!--</div>-->
        </div>
        <el-table
                :data="tableData"
                align
                border
                stripe
                style="width: 100%"
                size="mini"
                :default-sort="{prop: 'id', order: 'ascending'}"

                @selection-change="handleSelectionChange"
        >
            <!--v-loading="loading"-->
            <el-table-column
                    prop="id"
                    align="center"
                    width="60"
                    fixed
                    sortable
                    label="#"
                    :index="indexMethod"
            >
                <template slot-scope="scope">
                    <span>{{ scope.row.id }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    type="selection"
                    align="center"
            >
            </el-table-column>
            <el-table-column
                    label="用户名"
                    align="center"
            >
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ scope.row.username }}</el-tag>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="真实姓名"
                    align="center"
            >
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ scope.row.realname }}</el-tag>
                    </div>
                </template>
            </el-table-column>

            <el-table-column
                    label="所属用户组"
                    align="center"
            >
                <template slot-scope="scope">
                    <el-tag size="medium">{{ implode(scope.row.roles, 'name').join(',') }}</el-tag>
                </template>
            </el-table-column>

            <el-table-column
                    label="邮箱"
                    align="center"
            >
                <template slot-scope="scope">
                    <div slot="reference" class="name-wrapper">
                        <el-tag size="medium">{{ scope.row.email }}</el-tag>
                    </div>
                </template>
            </el-table-column>
            <el-table-column
                    label="最后登录时间"
                    align="center"
            >
                <template slot-scope="scope">
                    <i class="el-icon-time"></i> <span>{{ scope.row.logined_at }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="更新时间"
                    align="center"
            >
                <template slot-scope="scope">
                    <i class="el-icon-time"></i> <span>{{ scope.row.created_at }}</span>
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
                    label="所属项目"
                    align="center"
            >
                <template slot-scope="scope">
                    <el-tag size="medium">{{ implode(scope.row.items, 'name').join(',') }}</el-tag>    
                </template>
            </el-table-column>
            <el-table-column
                    label="管辖地区"
                    align="center"
            >
                <template slot-scope="scope">
                    <span style="margin-left: 10px"></span>
                </template>
            </el-table-column>

            <el-table-column label="操作" align="center" width="400">
                <template slot-scope="scope">
                    <el-button
                            size="mini"
                            type="primary"
                            style="margin-left:20px;float:left;"
                            @click="handleEdit(scope.$index, scope.row)">编辑
                    </el-button>
                    <el-button
                            size="mini"
                            type="danger"
                            style="float:left;"
                            @click="handleDelete(scope.$index, scope.row)">删除
                    </el-button>
                    <el-button
                            size="mini"
                            type="success"
                            style="float:left;"
                            @click="Jurisdiction(scope.row)"
                    >所属权限
                    </el-button>
                    <el-button
                            v-show="(implode(scope.row.roles, 'name').join(',')).indexOf('安监站') > -1"
                            size="mini"
                            type="warning"
                            style="float:left;"
                            @click="Edited_area"
                    >管辖地区
                    </el-button>
                </template>
            </el-table-column>
        </el-table>

        <el-dialog title="用户信息" :visible.sync="showForm" width="400px">
            <el-form :model="form" class="as-form-col">
                <el-form-item label="用户名" :label-width="formLabelWidth">
                    <el-input v-model="form.username" auto-complete="off" style="width:200px;" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="真实姓名" :label-width="formLabelWidth">
                    <el-input v-model="form.realname" auto-complete="off" style="width:200px;" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="邮箱" :label-width="formLabelWidth">
                    <el-input v-model="form.email" auto-complete="off" style="width:250px;" size="mini"></el-input>
                </el-form-item>
                <el-form-item label="所属用户组" :label-width="formLabelWidth">
                    <el-select v-model="form.role_id" multiple filterable placeholder="请选择" value-key="item">
                        <el-option
                                v-for="item in options"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="性别" :label-width="formLabelWidth">
                    <el-radio v-model="form.sex" :label="1">男</el-radio>
                    <el-radio v-model="form.sex" :label="2">女</el-radio>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="showForm = false">取 消</el-button>
                <el-button type="primary" @click="submitForm">确 定</el-button>
            </div>
        </el-dialog>


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

        <el-dialog title="所属权限" :visible.sync="projectItem">
            <el-form :model="form">
                <el-form-item label="项目名称" :label-width="formLabelWidth">
                    <el-input
                            type="textarea"
                            :rows="2"
                            placeholder="请输入内容"
                            v-model="textarea"
                            @focus="searchUnitBox"
                    >
                    </el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="projectItem = false">取 消</el-button>
                <el-button type="primary" @click="itemSenur">确 定</el-button>
            </div>
        </el-dialog>

        <search-box :chose="chose" :requestName="item" v-on:dbClickSelection="getItemValue" v-on:closeSearchBox="closeItemValue"></search-box>
    </div>
</template>

<script>
    import {getUsers, getRoles, updateUser, addUser, destroyUser, updataItem, getItem} from "../../api/user.js";
    import {implode} from "../../utils/common.js";
    import {pagesize, perPagesize} from '../../config/common'
    import SearchBox from '../../components/SearchBox.vue'

    export default {
        components: {
            SearchBox
        },
        data() {
            return {
                tableData: [],
                showForm: false,
                formType: '',
                //loading: true,
                form: {
                    username: "",
                    realname: "",
                    sex: '1',
                    password: "",
                    role_id: [],
                    email: "",
                },
                formLabelWidth: "100px",
                options: [],
                no: '',
                currentPage: 1,
                multipleSelection: [],
                regionShow: false,
                currentPage: 1, //当前页数
                pagesize: pagesize,
                perPagesize: perPagesize,
                total: null,
                distribution: false,
                chose: false,  //是否显示
                item: 'item',
                projectItem: false,
                textarea: '',
                itemIdsSelected: [],
                userId: '',
            };
        },
        created() {
            getUsers(this.currentPage).then(res => {
                console.log(res)
                this.tableData = res.data.data.data;
            }),
                getRoles().then(res => {
                    if (res.data.response_status === "success") {
                        this.options = res.data.data;

                    }
                })
        },
        methods: {
            handleSizeChange(pagesize) {
                this.pagesize = pagesize
                this.getUsers()
            },
            handleCurrentChange(currentPage) {
                this.currentPage = currentPage

                this.$router.replace({
                    path: this.$route.path,
                    query: {page: this.currentPage}
                })
                this.getUsers()
            },
            indexMethod(index) {
                return index + (this.currentPage - 1) * this.pagesize;
            },
            handleCrane() {
                this.distribution = true
            },
            handleEdit(index, row) {
                // 给表单赋值
                this.formType = 'edit'
                this.form = {
                    username: row.username,
                    realname: row.realname,
                    sex: row.sex,
                    password: "",
                    email: row.email
                };
                this.$set(this.form, 'role_id', implode(row.roles, 'id'))
                this.showForm = true;
                this.no = row.id
            },
            handleAdd() {
                // 重新初始化表单
                this.formType = 'add'
                this.form = {
                    username: "",
                    realname: "",
                    sex: 1,
                    password: "",
                    role_id: [],
                    email: ""
                };
                this.showForm = true;
            },
            handleDelete(index, row) {
                this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    destroyUser(row.id, this.currentPage).then(res => {
                        if (res.data.response_status === "success") {
                            // 改变tableData
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
            handleDeleteSeleted() {
                this.$confirm('此操作将永久删除该记录, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning',
                    center: true
                }).then(() => {
                    destroyUser(this.multipleSelection, this.currentPage).then(res => {
                        if (res.data.response_status === "success") {
                            // 改变tableData
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
            submitForm() {
                if (this.formType === 'edit') {
                    updateUser(this.no, this.form).then(res => {
                        this.showForm = false
                        this.$message({
                            type: 'success',
                            showClose: true,
                            message: res.data.msg
                        })
                        this.tableData.forEach((elem, index) => {
                            if (elem.id == this.no) {
                                this.$set(this.tableData, index, res.data.data)
                            }
                        })
                    })
                } else {
                    addUser(this.form).then(res => {
                        if (res.data.response_status === 'success') {
                            this.tableData = res.data.data.users.data

                            let username = res.data.data.userInfo['username']
                            let password = res.data.data.userInfo['password']
                            this.$alert(`用户名：${username}<br>密 &nbsp;&nbsp;码：${password}`, '用户信息', {
                                confirmButtonText: '确定',
                                dangerouslyUseHTMLString: true,
                                callback: action => {
                                    this.$message({
                                        type: 'success',
                                        message: res.data.msg
                                    });
                                }
                            });
                        }
                        this.showForm = false
                    })
                }

            },
            handleSelectionChange(val) {
                this.multipleSelection = implode(val, 'id')
            },
            implode(arr, attr) {
                return implode(arr, attr);
            },
            searchUnitBox() {
                this.chose = true
            },
            getItemValue(row) {
                this.chose = false
                if (!this.textarea) {
                    this.textarea = row.name
                } else {
                    this.textarea += ', ' + row.name
                }
                this.itemIdsSelected.push(row.id)
            },
            closeItemValue() {
                this.chose = false
            },
            Edited_area() {
            },
            Jurisdiction(row) {
                this.projectItem = true
                this.userId = row.id
                this.itemIdsSelected = implode(row.items, 'id')
                getItem(this.userId).then(res=>{
                    this.textarea = implode(res.data.data, 'name').join(', ')
                })
            },
            itemSenur() {
                updataItem(this.userId, this.itemIdsSelected, this.pagesize, this.currentPage).then(res => {
                    this.tableData = res.data.data.data
                    this.$message({
                        type: 'success',
                        showClose: true,
                        message: res.data.msg
                    })
                })
                this.projectItem = false
            }
        },
    };
</script>

<style scoped>
    .el-form-item {
        margin-bottom: 0px;
    }
</style>
